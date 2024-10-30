// Require

/* Lib Require via Gulp*/
/**!
 * Sortable
 * @author	RubaXa   <trash@rubaxa.org>
 * @license MIT
 */

(function sortableModule(factory) {
    "use strict";

    if (typeof define === "function" && define.amd) {
        define(factory);
    } else if (typeof module != "undefined" && typeof module.exports != "undefined") {
        module.exports = factory();
    } else {
        /* jshint sub:true */
        window["Sortable"] = factory();
    }
})(function sortableFactory() {
    "use strict";

    if (typeof window === "undefined" || !window.document) {
        return function sortableError() {
            throw new Error("Sortable.js requires a window with a document");
        };
    }

    var dragEl,
        parentEl,
        ghostEl,
        cloneEl,
        rootEl,
        nextEl,
        lastDownEl,
        scrollEl,
        scrollParentEl,
        scrollCustomFn,
        lastEl,
        lastCSS,
        lastParentCSS,
        oldIndex,
        newIndex,
        activeGroup,
        putSortable,
        autoScroll = {},
        tapEvt,
        touchEvt,
        moved,


    /** @const */
    R_SPACE = /\s+/g,
        R_FLOAT = /left|right|inline/,
        expando = 'Sortable' + new Date().getTime(),
        win = window,
        document = win.document,
        parseInt = win.parseInt,
        setTimeout = win.setTimeout,
        $ = win.jQuery || win.Zepto,
        Polymer = win.Polymer,
        captureMode = false,
        passiveMode = false,
        supportDraggable = 'draggable' in document.createElement('div'),
        supportCssPointerEvents = function (el) {
        // false when IE11
        if (!!navigator.userAgent.match(/(?:Trident.*rv[ :]?11\.|msie)/i)) {
            return false;
        }
        el = document.createElement('x');
        el.style.cssText = 'pointer-events:auto';
        return el.style.pointerEvents === 'auto';
    }(),
        _silent = false,
        abs = Math.abs,
        min = Math.min,
        savedInputChecked = [],
        touchDragOverListeners = [],
        _autoScroll = _throttle(function ( /**Event*/evt, /**Object*/options, /**HTMLElement*/rootEl) {
        // Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=505521
        if (rootEl && options.scroll) {
            var _this = rootEl[expando],
                el,
                rect,
                sens = options.scrollSensitivity,
                speed = options.scrollSpeed,
                x = evt.clientX,
                y = evt.clientY,
                winWidth = window.innerWidth,
                winHeight = window.innerHeight,
                vx,
                vy,
                scrollOffsetX,
                scrollOffsetY;

            // Delect scrollEl
            if (scrollParentEl !== rootEl) {
                scrollEl = options.scroll;
                scrollParentEl = rootEl;
                scrollCustomFn = options.scrollFn;

                if (scrollEl === true) {
                    scrollEl = rootEl;

                    do {
                        if (scrollEl.offsetWidth < scrollEl.scrollWidth || scrollEl.offsetHeight < scrollEl.scrollHeight) {
                            break;
                        }
                        /* jshint boss:true */
                    } while (scrollEl = scrollEl.parentNode);
                }
            }

            if (scrollEl) {
                el = scrollEl;
                rect = scrollEl.getBoundingClientRect();
                vx = (abs(rect.right - x) <= sens) - (abs(rect.left - x) <= sens);
                vy = (abs(rect.bottom - y) <= sens) - (abs(rect.top - y) <= sens);
            }

            if (!(vx || vy)) {
                vx = (winWidth - x <= sens) - (x <= sens);
                vy = (winHeight - y <= sens) - (y <= sens);

                /* jshint expr:true */
                (vx || vy) && (el = win);
            }

            if (autoScroll.vx !== vx || autoScroll.vy !== vy || autoScroll.el !== el) {
                autoScroll.el = el;
                autoScroll.vx = vx;
                autoScroll.vy = vy;

                clearInterval(autoScroll.pid);

                if (el) {
                    autoScroll.pid = setInterval(function () {
                        scrollOffsetY = vy ? vy * speed : 0;
                        scrollOffsetX = vx ? vx * speed : 0;

                        if ('function' === typeof scrollCustomFn) {
                            return scrollCustomFn.call(_this, scrollOffsetX, scrollOffsetY, evt);
                        }

                        if (el === win) {
                            win.scrollTo(win.pageXOffset + scrollOffsetX, win.pageYOffset + scrollOffsetY);
                        } else {
                            el.scrollTop += scrollOffsetY;
                            el.scrollLeft += scrollOffsetX;
                        }
                    }, 24);
                }
            }
        }
    }, 30),
        _prepareGroup = function (options) {
        function toFn(value, pull) {
            if (value === void 0 || value === true) {
                value = group.name;
            }

            if (typeof value === 'function') {
                return value;
            } else {
                return function (to, from) {
                    var fromGroup = from.options.group.name;

                    return pull ? value : value && (value.join ? value.indexOf(fromGroup) > -1 : fromGroup == value);
                };
            }
        }

        var group = {};
        var originalGroup = options.group;

        if (!originalGroup || typeof originalGroup != 'object') {
            originalGroup = { name: originalGroup };
        }

        group.name = originalGroup.name;
        group.checkPull = toFn(originalGroup.pull, true);
        group.checkPut = toFn(originalGroup.put);
        group.revertClone = originalGroup.revertClone;

        options.group = group;
    };

    // Detect support a passive mode
    try {
        window.addEventListener('test', null, Object.defineProperty({}, 'passive', {
            get: function () {
                // `false`, because everything starts to work incorrectly and instead of d'n'd,
                // begins the page has scrolled.
                passiveMode = false;
                captureMode = {
                    capture: false,
                    passive: passiveMode
                };
            }
        }));
    } catch (err) {}

    /**
     * @class  Sortable
     * @param  {HTMLElement}  el
     * @param  {Object}       [options]
     */
    function Sortable(el, options) {
        if (!(el && el.nodeType && el.nodeType === 1)) {
            throw 'Sortable: `el` must be HTMLElement, and not ' + {}.toString.call(el);
        }

        this.el = el; // root element
        this.options = options = _extend({}, options);

        // Export instance
        el[expando] = this;

        // Default options
        var defaults = {
            group: Math.random(),
            sort: true,
            disabled: false,
            store: null,
            handle: null,
            scroll: true,
            scrollSensitivity: 30,
            scrollSpeed: 10,
            draggable: /[uo]l/i.test(el.nodeName) ? 'li' : '>*',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            ignore: 'a, img',
            filter: null,
            preventOnFilter: true,
            animation: 0,
            setData: function (dataTransfer, dragEl) {
                dataTransfer.setData('Text', dragEl.textContent);
            },
            dropBubble: false,
            dragoverBubble: false,
            dataIdAttr: 'data-id',
            delay: 0,
            forceFallback: false,
            fallbackClass: 'sortable-fallback',
            fallbackOnBody: false,
            fallbackTolerance: 0,
            fallbackOffset: { x: 0, y: 0 },
            supportPointer: Sortable.supportPointer !== false
        };

        // Set default options
        for (var name in defaults) {
            !(name in options) && (options[name] = defaults[name]);
        }

        _prepareGroup(options);

        // Bind all private methods
        for (var fn in this) {
            if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
                this[fn] = this[fn].bind(this);
            }
        }

        // Setup drag mode
        this.nativeDraggable = options.forceFallback ? false : supportDraggable;

        // Bind events
        _on(el, 'mousedown', this._onTapStart);
        _on(el, 'touchstart', this._onTapStart);
        options.supportPointer && _on(el, 'pointerdown', this._onTapStart);

        if (this.nativeDraggable) {
            _on(el, 'dragover', this);
            _on(el, 'dragenter', this);
        }

        touchDragOverListeners.push(this._onDragOver);

        // Restore sorting
        options.store && this.sort(options.store.get(this));
    }

    Sortable.prototype = /** @lends Sortable.prototype */{
        constructor: Sortable,

        _onTapStart: function ( /** Event|TouchEvent */evt) {
            var _this = this,
                el = this.el,
                options = this.options,
                preventOnFilter = options.preventOnFilter,
                type = evt.type,
                touch = evt.touches && evt.touches[0],
                target = (touch || evt).target,
                originalTarget = evt.target.shadowRoot && evt.path && evt.path[0] || target,
                filter = options.filter,
                startIndex;

            _saveInputCheckedState(el);

            // Don't trigger start event when an element is been dragged, otherwise the evt.oldindex always wrong when set option.group.
            if (dragEl) {
                return;
            }

            if (/mousedown|pointerdown/.test(type) && evt.button !== 0 || options.disabled) {
                return; // only left button or enabled
            }

            // cancel dnd if original target is content editable
            if (originalTarget.isContentEditable) {
                return;
            }

            target = _closest(target, options.draggable, el);

            if (!target) {
                return;
            }

            if (lastDownEl === target) {
                // Ignoring duplicate `down`
                return;
            }

            // Get the index of the dragged element within its parent
            startIndex = _index(target, options.draggable);

            // Check filter
            if (typeof filter === 'function') {
                if (filter.call(this, evt, target, this)) {
                    _dispatchEvent(_this, originalTarget, 'filter', target, el, el, startIndex);
                    preventOnFilter && evt.preventDefault();
                    return; // cancel dnd
                }
            } else if (filter) {
                filter = filter.split(',').some(function (criteria) {
                    criteria = _closest(originalTarget, criteria.trim(), el);

                    if (criteria) {
                        _dispatchEvent(_this, criteria, 'filter', target, el, el, startIndex);
                        return true;
                    }
                });

                if (filter) {
                    preventOnFilter && evt.preventDefault();
                    return; // cancel dnd
                }
            }

            if (options.handle && !_closest(originalTarget, options.handle, el)) {
                return;
            }

            // Prepare `dragstart`
            this._prepareDragStart(evt, touch, target, startIndex);
        },

        _prepareDragStart: function ( /** Event */evt, /** Touch */touch, /** HTMLElement */target, /** Number */startIndex) {
            var _this = this,
                el = _this.el,
                options = _this.options,
                ownerDocument = el.ownerDocument,
                dragStartFn;

            if (target && !dragEl && target.parentNode === el) {
                tapEvt = evt;

                rootEl = el;
                dragEl = target;
                parentEl = dragEl.parentNode;
                nextEl = dragEl.nextSibling;
                lastDownEl = target;
                activeGroup = options.group;
                oldIndex = startIndex;

                this._lastX = (touch || evt).clientX;
                this._lastY = (touch || evt).clientY;

                dragEl.style['will-change'] = 'all';

                dragStartFn = function () {
                    // Delayed drag has been triggered
                    // we can re-enable the events: touchmove/mousemove
                    _this._disableDelayedDrag();

                    // Make the element draggable
                    dragEl.draggable = _this.nativeDraggable;

                    // Chosen item
                    _toggleClass(dragEl, options.chosenClass, true);

                    // Bind the events: dragstart/dragend
                    _this._triggerDragStart(evt, touch);

                    // Drag start event
                    _dispatchEvent(_this, rootEl, 'choose', dragEl, rootEl, rootEl, oldIndex);
                };

                // Disable "draggable"
                options.ignore.split(',').forEach(function (criteria) {
                    _find(dragEl, criteria.trim(), _disableDraggable);
                });

                _on(ownerDocument, 'mouseup', _this._onDrop);
                _on(ownerDocument, 'touchend', _this._onDrop);
                _on(ownerDocument, 'touchcancel', _this._onDrop);
                _on(ownerDocument, 'selectstart', _this);
                options.supportPointer && _on(ownerDocument, 'pointercancel', _this._onDrop);

                if (options.delay) {
                    // If the user moves the pointer or let go the click or touch
                    // before the delay has been reached:
                    // disable the delayed drag
                    _on(ownerDocument, 'mouseup', _this._disableDelayedDrag);
                    _on(ownerDocument, 'touchend', _this._disableDelayedDrag);
                    _on(ownerDocument, 'touchcancel', _this._disableDelayedDrag);
                    _on(ownerDocument, 'mousemove', _this._disableDelayedDrag);
                    _on(ownerDocument, 'touchmove', _this._disableDelayedDrag);
                    options.supportPointer && _on(ownerDocument, 'pointermove', _this._disableDelayedDrag);

                    _this._dragStartTimer = setTimeout(dragStartFn, options.delay);
                } else {
                    dragStartFn();
                }
            }
        },

        _disableDelayedDrag: function () {
            var ownerDocument = this.el.ownerDocument;

            clearTimeout(this._dragStartTimer);
            _off(ownerDocument, 'mouseup', this._disableDelayedDrag);
            _off(ownerDocument, 'touchend', this._disableDelayedDrag);
            _off(ownerDocument, 'touchcancel', this._disableDelayedDrag);
            _off(ownerDocument, 'mousemove', this._disableDelayedDrag);
            _off(ownerDocument, 'touchmove', this._disableDelayedDrag);
            _off(ownerDocument, 'pointermove', this._disableDelayedDrag);
        },

        _triggerDragStart: function ( /** Event */evt, /** Touch */touch) {
            touch = touch || (evt.pointerType == 'touch' ? evt : null);

            if (touch) {
                // Touch device support
                tapEvt = {
                    target: dragEl,
                    clientX: touch.clientX,
                    clientY: touch.clientY
                };

                this._onDragStart(tapEvt, 'touch');
            } else if (!this.nativeDraggable) {
                this._onDragStart(tapEvt, true);
            } else {
                _on(dragEl, 'dragend', this);
                _on(rootEl, 'dragstart', this._onDragStart);
            }

            try {
                if (document.selection) {
                    // Timeout neccessary for IE9
                    _nextTick(function () {
                        document.selection.empty();
                    });
                } else {
                    window.getSelection().removeAllRanges();
                }
            } catch (err) {}
        },

        _dragStarted: function () {
            if (rootEl && dragEl) {
                var options = this.options;

                // Apply effect
                _toggleClass(dragEl, options.ghostClass, true);
                _toggleClass(dragEl, options.dragClass, false);

                Sortable.active = this;

                // Drag start event
                _dispatchEvent(this, rootEl, 'start', dragEl, rootEl, rootEl, oldIndex);
            } else {
                this._nulling();
            }
        },

        _emulateDragOver: function () {
            if (touchEvt) {
                if (this._lastX === touchEvt.clientX && this._lastY === touchEvt.clientY) {
                    return;
                }

                this._lastX = touchEvt.clientX;
                this._lastY = touchEvt.clientY;

                if (!supportCssPointerEvents) {
                    _css(ghostEl, 'display', 'none');
                }

                var target = document.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
                var parent = target;
                var i = touchDragOverListeners.length;

                if (target && target.shadowRoot) {
                    target = target.shadowRoot.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
                    parent = target;
                }

                if (parent) {
                    do {
                        if (parent[expando]) {
                            while (i--) {
                                touchDragOverListeners[i]({
                                    clientX: touchEvt.clientX,
                                    clientY: touchEvt.clientY,
                                    target: target,
                                    rootEl: parent
                                });
                            }

                            break;
                        }

                        target = parent; // store last element
                    }
                    /* jshint boss:true */
                    while (parent = parent.parentNode);
                }

                if (!supportCssPointerEvents) {
                    _css(ghostEl, 'display', '');
                }
            }
        },

        _onTouchMove: function ( /**TouchEvent*/evt) {
            if (tapEvt) {
                var options = this.options,
                    fallbackTolerance = options.fallbackTolerance,
                    fallbackOffset = options.fallbackOffset,
                    touch = evt.touches ? evt.touches[0] : evt,
                    dx = touch.clientX - tapEvt.clientX + fallbackOffset.x,
                    dy = touch.clientY - tapEvt.clientY + fallbackOffset.y,
                    translate3d = evt.touches ? 'translate3d(' + dx + 'px,' + dy + 'px,0)' : 'translate(' + dx + 'px,' + dy + 'px)';

                // only set the status to dragging, when we are actually dragging
                if (!Sortable.active) {
                    if (fallbackTolerance && min(abs(touch.clientX - this._lastX), abs(touch.clientY - this._lastY)) < fallbackTolerance) {
                        return;
                    }

                    this._dragStarted();
                }

                // as well as creating the ghost element on the document body
                this._appendGhost();

                moved = true;
                touchEvt = touch;

                _css(ghostEl, 'webkitTransform', translate3d);
                _css(ghostEl, 'mozTransform', translate3d);
                _css(ghostEl, 'msTransform', translate3d);
                _css(ghostEl, 'transform', translate3d);

                evt.preventDefault();
            }
        },

        _appendGhost: function () {
            if (!ghostEl) {
                var rect = dragEl.getBoundingClientRect(),
                    css = _css(dragEl),
                    options = this.options,
                    ghostRect;

                ghostEl = dragEl.cloneNode(true);

                _toggleClass(ghostEl, options.ghostClass, false);
                _toggleClass(ghostEl, options.fallbackClass, true);
                _toggleClass(ghostEl, options.dragClass, true);

                _css(ghostEl, 'top', rect.top - parseInt(css.marginTop, 10));
                _css(ghostEl, 'left', rect.left - parseInt(css.marginLeft, 10));
                _css(ghostEl, 'width', rect.width);
                _css(ghostEl, 'height', rect.height);
                _css(ghostEl, 'opacity', '0.8');
                _css(ghostEl, 'position', 'fixed');
                _css(ghostEl, 'zIndex', '100000');
                _css(ghostEl, 'pointerEvents', 'none');

                options.fallbackOnBody && document.body.appendChild(ghostEl) || rootEl.appendChild(ghostEl);

                // Fixing dimensions.
                ghostRect = ghostEl.getBoundingClientRect();
                _css(ghostEl, 'width', rect.width * 2 - ghostRect.width);
                _css(ghostEl, 'height', rect.height * 2 - ghostRect.height);
            }
        },

        _onDragStart: function ( /**Event*/evt, /**boolean*/useFallback) {
            var _this = this;
            var dataTransfer = evt.dataTransfer;
            var options = _this.options;

            _this._offUpEvents();

            if (activeGroup.checkPull(_this, _this, dragEl, evt)) {
                cloneEl = _clone(dragEl);

                cloneEl.draggable = false;
                cloneEl.style['will-change'] = '';

                _css(cloneEl, 'display', 'none');
                _toggleClass(cloneEl, _this.options.chosenClass, false);

                // #1143: IFrame support workaround
                _this._cloneId = _nextTick(function () {
                    rootEl.insertBefore(cloneEl, dragEl);
                    _dispatchEvent(_this, rootEl, 'clone', dragEl);
                });
            }

            _toggleClass(dragEl, options.dragClass, true);

            if (useFallback) {
                if (useFallback === 'touch') {
                    // Bind touch events
                    _on(document, 'touchmove', _this._onTouchMove);
                    _on(document, 'touchend', _this._onDrop);
                    _on(document, 'touchcancel', _this._onDrop);

                    if (options.supportPointer) {
                        _on(document, 'pointermove', _this._onTouchMove);
                        _on(document, 'pointerup', _this._onDrop);
                    }
                } else {
                    // Old brwoser
                    _on(document, 'mousemove', _this._onTouchMove);
                    _on(document, 'mouseup', _this._onDrop);
                }

                _this._loopId = setInterval(_this._emulateDragOver, 50);
            } else {
                if (dataTransfer) {
                    dataTransfer.effectAllowed = 'move';
                    options.setData && options.setData.call(_this, dataTransfer, dragEl);
                }

                _on(document, 'drop', _this);

                // #1143: Бывает элемент с IFrame внутри блокирует `drop`,
                // поэтому если вызвался `mouseover`, значит надо отменять весь d'n'd.
                // Breaking Chrome 62+
                // _on(document, 'mouseover', _this);

                _this._dragStartId = _nextTick(_this._dragStarted);
            }
        },

        _onDragOver: function ( /**Event*/evt) {
            var el = this.el,
                target,
                dragRect,
                targetRect,
                revert,
                options = this.options,
                group = options.group,
                activeSortable = Sortable.active,
                isOwner = activeGroup === group,
                isMovingBetweenSortable = false,
                canSort = options.sort;

            if (evt.preventDefault !== void 0) {
                evt.preventDefault();
                !options.dragoverBubble && evt.stopPropagation();
            }

            if (dragEl.animated) {
                return;
            }

            moved = true;

            if (activeSortable && !options.disabled && (isOwner ? canSort || (revert = !rootEl.contains(dragEl)) // Reverting item into the original list
            : putSortable === this || (activeSortable.lastPullMode = activeGroup.checkPull(this, activeSortable, dragEl, evt)) && group.checkPut(this, activeSortable, dragEl, evt)) && (evt.rootEl === void 0 || evt.rootEl === this.el) // touch fallback
            ) {
                    // Smart auto-scrolling
                    _autoScroll(evt, options, this.el);

                    if (_silent) {
                        return;
                    }

                    target = _closest(evt.target, options.draggable, el);
                    dragRect = dragEl.getBoundingClientRect();

                    if (putSortable !== this) {
                        putSortable = this;
                        isMovingBetweenSortable = true;
                    }

                    if (revert) {
                        _cloneHide(activeSortable, true);
                        parentEl = rootEl; // actualization

                        if (cloneEl || nextEl) {
                            rootEl.insertBefore(dragEl, cloneEl || nextEl);
                        } else if (!canSort) {
                            rootEl.appendChild(dragEl);
                        }

                        return;
                    }

                    if (el.children.length === 0 || el.children[0] === ghostEl || el === evt.target && _ghostIsLast(el, evt)) {
                        //assign target only if condition is true
                        if (el.children.length !== 0 && el.children[0] !== ghostEl && el === evt.target) {
                            target = el.lastElementChild;
                        }

                        if (target) {
                            if (target.animated) {
                                return;
                            }

                            targetRect = target.getBoundingClientRect();
                        }

                        _cloneHide(activeSortable, isOwner);

                        if (_onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt) !== false) {
                            if (!dragEl.contains(el)) {
                                el.appendChild(dragEl);
                                parentEl = el; // actualization
                            }

                            this._animate(dragRect, dragEl);
                            target && this._animate(targetRect, target);
                        }
                    } else if (target && !target.animated && target !== dragEl && target.parentNode[expando] !== void 0) {
                        if (lastEl !== target) {
                            lastEl = target;
                            lastCSS = _css(target);
                            lastParentCSS = _css(target.parentNode);
                        }

                        targetRect = target.getBoundingClientRect();

                        var width = targetRect.right - targetRect.left,
                            height = targetRect.bottom - targetRect.top,
                            floating = R_FLOAT.test(lastCSS.cssFloat + lastCSS.display) || lastParentCSS.display == 'flex' && lastParentCSS['flex-direction'].indexOf('row') === 0,
                            isWide = target.offsetWidth > dragEl.offsetWidth,
                            isLong = target.offsetHeight > dragEl.offsetHeight,
                            halfway = (floating ? (evt.clientX - targetRect.left) / width : (evt.clientY - targetRect.top) / height) > 0.5,
                            nextSibling = target.nextElementSibling,
                            after = false;

                        if (floating) {
                            var elTop = dragEl.offsetTop,
                                tgTop = target.offsetTop;

                            if (elTop === tgTop) {
                                after = target.previousElementSibling === dragEl && !isWide || halfway && isWide;
                            } else if (target.previousElementSibling === dragEl || dragEl.previousElementSibling === target) {
                                after = (evt.clientY - targetRect.top) / height > 0.5;
                            } else {
                                after = tgTop > elTop;
                            }
                        } else if (!isMovingBetweenSortable) {
                            after = nextSibling !== dragEl && !isLong || halfway && isLong;
                        }

                        var moveVector = _onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, after);

                        if (moveVector !== false) {
                            if (moveVector === 1 || moveVector === -1) {
                                after = moveVector === 1;
                            }

                            _silent = true;
                            setTimeout(_unsilent, 30);

                            _cloneHide(activeSortable, isOwner);

                            if (!dragEl.contains(el)) {
                                if (after && !nextSibling) {
                                    el.appendChild(dragEl);
                                } else {
                                    target.parentNode.insertBefore(dragEl, after ? nextSibling : target);
                                }
                            }

                            parentEl = dragEl.parentNode; // actualization

                            this._animate(dragRect, dragEl);
                            this._animate(targetRect, target);
                        }
                    }
                }
        },

        _animate: function (prevRect, target) {
            var ms = this.options.animation;

            if (ms) {
                var currentRect = target.getBoundingClientRect();

                if (prevRect.nodeType === 1) {
                    prevRect = prevRect.getBoundingClientRect();
                }

                _css(target, 'transition', 'none');
                _css(target, 'transform', 'translate3d(' + (prevRect.left - currentRect.left) + 'px,' + (prevRect.top - currentRect.top) + 'px,0)');

                target.offsetWidth; // repaint

                _css(target, 'transition', 'all ' + ms + 'ms');
                _css(target, 'transform', 'translate3d(0,0,0)');

                clearTimeout(target.animated);
                target.animated = setTimeout(function () {
                    _css(target, 'transition', '');
                    _css(target, 'transform', '');
                    target.animated = false;
                }, ms);
            }
        },

        _offUpEvents: function () {
            var ownerDocument = this.el.ownerDocument;

            _off(document, 'touchmove', this._onTouchMove);
            _off(document, 'pointermove', this._onTouchMove);
            _off(ownerDocument, 'mouseup', this._onDrop);
            _off(ownerDocument, 'touchend', this._onDrop);
            _off(ownerDocument, 'pointerup', this._onDrop);
            _off(ownerDocument, 'touchcancel', this._onDrop);
            _off(ownerDocument, 'pointercancel', this._onDrop);
            _off(ownerDocument, 'selectstart', this);
        },

        _onDrop: function ( /**Event*/evt) {
            var el = this.el,
                options = this.options;

            clearInterval(this._loopId);
            clearInterval(autoScroll.pid);
            clearTimeout(this._dragStartTimer);

            _cancelNextTick(this._cloneId);
            _cancelNextTick(this._dragStartId);

            // Unbind events
            _off(document, 'mouseover', this);
            _off(document, 'mousemove', this._onTouchMove);

            if (this.nativeDraggable) {
                _off(document, 'drop', this);
                _off(el, 'dragstart', this._onDragStart);
            }

            this._offUpEvents();

            if (evt) {
                if (moved) {
                    evt.preventDefault();
                    !options.dropBubble && evt.stopPropagation();
                }

                ghostEl && ghostEl.parentNode && ghostEl.parentNode.removeChild(ghostEl);

                if (rootEl === parentEl || Sortable.active.lastPullMode !== 'clone') {
                    // Remove clone
                    cloneEl && cloneEl.parentNode && cloneEl.parentNode.removeChild(cloneEl);
                }

                if (dragEl) {
                    if (this.nativeDraggable) {
                        _off(dragEl, 'dragend', this);
                    }

                    _disableDraggable(dragEl);
                    dragEl.style['will-change'] = '';

                    // Remove class's
                    _toggleClass(dragEl, this.options.ghostClass, false);
                    _toggleClass(dragEl, this.options.chosenClass, false);

                    // Drag stop event
                    _dispatchEvent(this, rootEl, 'unchoose', dragEl, parentEl, rootEl, oldIndex);

                    if (rootEl !== parentEl) {
                        newIndex = _index(dragEl, options.draggable);

                        if (newIndex >= 0) {
                            // Add event
                            _dispatchEvent(null, parentEl, 'add', dragEl, parentEl, rootEl, oldIndex, newIndex);

                            // Remove event
                            _dispatchEvent(this, rootEl, 'remove', dragEl, parentEl, rootEl, oldIndex, newIndex);

                            // drag from one list and drop into another
                            _dispatchEvent(null, parentEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
                            _dispatchEvent(this, rootEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
                        }
                    } else {
                        if (dragEl.nextSibling !== nextEl) {
                            // Get the index of the dragged element within its parent
                            newIndex = _index(dragEl, options.draggable);

                            if (newIndex >= 0) {
                                // drag & drop within the same list
                                _dispatchEvent(this, rootEl, 'update', dragEl, parentEl, rootEl, oldIndex, newIndex);
                                _dispatchEvent(this, rootEl, 'sort', dragEl, parentEl, rootEl, oldIndex, newIndex);
                            }
                        }
                    }

                    if (Sortable.active) {
                        /* jshint eqnull:true */
                        if (newIndex == null || newIndex === -1) {
                            newIndex = oldIndex;
                        }

                        _dispatchEvent(this, rootEl, 'end', dragEl, parentEl, rootEl, oldIndex, newIndex);

                        // Save sorting
                        this.save();
                    }
                }
            }

            this._nulling();
        },

        _nulling: function () {
            rootEl = dragEl = parentEl = ghostEl = nextEl = cloneEl = lastDownEl = scrollEl = scrollParentEl = tapEvt = touchEvt = moved = newIndex = lastEl = lastCSS = putSortable = activeGroup = Sortable.active = null;

            savedInputChecked.forEach(function (el) {
                el.checked = true;
            });
            savedInputChecked.length = 0;
        },

        handleEvent: function ( /**Event*/evt) {
            switch (evt.type) {
                case 'drop':
                case 'dragend':
                    this._onDrop(evt);
                    break;

                case 'dragover':
                case 'dragenter':
                    if (dragEl) {
                        this._onDragOver(evt);
                        _globalDragOver(evt);
                    }
                    break;

                case 'mouseover':
                    this._onDrop(evt);
                    break;

                case 'selectstart':
                    evt.preventDefault();
                    break;
            }
        },

        /**
         * Serializes the item into an array of string.
         * @returns {String[]}
         */
        toArray: function () {
            var order = [],
                el,
                children = this.el.children,
                i = 0,
                n = children.length,
                options = this.options;

            for (; i < n; i++) {
                el = children[i];
                if (_closest(el, options.draggable, this.el)) {
                    order.push(el.getAttribute(options.dataIdAttr) || _generateId(el));
                }
            }

            return order;
        },

        /**
         * Sorts the elements according to the array.
         * @param  {String[]}  order  order of the items
         */
        sort: function (order) {
            var items = {},
                rootEl = this.el;

            this.toArray().forEach(function (id, i) {
                var el = rootEl.children[i];

                if (_closest(el, this.options.draggable, rootEl)) {
                    items[id] = el;
                }
            }, this);

            order.forEach(function (id) {
                if (items[id]) {
                    rootEl.removeChild(items[id]);
                    rootEl.appendChild(items[id]);
                }
            });
        },

        /**
         * Save the current sorting
         */
        save: function () {
            var store = this.options.store;
            store && store.set(this);
        },

        /**
         * For each element in the set, get the first element that matches the selector by testing the element itself and traversing up through its ancestors in the DOM tree.
         * @param   {HTMLElement}  el
         * @param   {String}       [selector]  default: `options.draggable`
         * @returns {HTMLElement|null}
         */
        closest: function (el, selector) {
            return _closest(el, selector || this.options.draggable, this.el);
        },

        /**
         * Set/get option
         * @param   {string} name
         * @param   {*}      [value]
         * @returns {*}
         */
        option: function (name, value) {
            var options = this.options;

            if (value === void 0) {
                return options[name];
            } else {
                options[name] = value;

                if (name === 'group') {
                    _prepareGroup(options);
                }
            }
        },

        /**
         * Destroy
         */
        destroy: function () {
            var el = this.el;

            el[expando] = null;

            _off(el, 'mousedown', this._onTapStart);
            _off(el, 'touchstart', this._onTapStart);
            _off(el, 'pointerdown', this._onTapStart);

            if (this.nativeDraggable) {
                _off(el, 'dragover', this);
                _off(el, 'dragenter', this);
            }

            // Remove draggable attributes
            Array.prototype.forEach.call(el.querySelectorAll('[draggable]'), function (el) {
                el.removeAttribute('draggable');
            });

            touchDragOverListeners.splice(touchDragOverListeners.indexOf(this._onDragOver), 1);

            this._onDrop();

            this.el = el = null;
        }
    };

    function _cloneHide(sortable, state) {
        if (sortable.lastPullMode !== 'clone') {
            state = true;
        }

        if (cloneEl && cloneEl.state !== state) {
            _css(cloneEl, 'display', state ? 'none' : '');

            if (!state) {
                if (cloneEl.state) {
                    if (sortable.options.group.revertClone) {
                        rootEl.insertBefore(cloneEl, nextEl);
                        sortable._animate(dragEl, cloneEl);
                    } else {
                        rootEl.insertBefore(cloneEl, dragEl);
                    }
                }
            }

            cloneEl.state = state;
        }
    }

    function _closest( /**HTMLElement*/el, /**String*/selector, /**HTMLElement*/ctx) {
        if (el) {
            ctx = ctx || document;

            do {
                if (selector === '>*' && el.parentNode === ctx || _matches(el, selector)) {
                    return el;
                }
                /* jshint boss:true */
            } while (el = _getParentOrHost(el));
        }

        return null;
    }

    function _getParentOrHost(el) {
        var parent = el.host;

        return parent && parent.nodeType ? parent : el.parentNode;
    }

    function _globalDragOver( /**Event*/evt) {
        if (evt.dataTransfer) {
            evt.dataTransfer.dropEffect = 'move';
        }
        evt.preventDefault();
    }

    function _on(el, event, fn) {
        el.addEventListener(event, fn, captureMode);
    }

    function _off(el, event, fn) {
        el.removeEventListener(event, fn, captureMode);
    }

    function _toggleClass(el, name, state) {
        if (el) {
            if (el.classList) {
                el.classList[state ? 'add' : 'remove'](name);
            } else {
                var className = (' ' + el.className + ' ').replace(R_SPACE, ' ').replace(' ' + name + ' ', ' ');
                el.className = (className + (state ? ' ' + name : '')).replace(R_SPACE, ' ');
            }
        }
    }

    function _css(el, prop, val) {
        var style = el && el.style;

        if (style) {
            if (val === void 0) {
                if (document.defaultView && document.defaultView.getComputedStyle) {
                    val = document.defaultView.getComputedStyle(el, '');
                } else if (el.currentStyle) {
                    val = el.currentStyle;
                }

                return prop === void 0 ? val : val[prop];
            } else {
                if (!(prop in style)) {
                    prop = '-webkit-' + prop;
                }

                style[prop] = val + (typeof val === 'string' ? '' : 'px');
            }
        }
    }

    function _find(ctx, tagName, iterator) {
        if (ctx) {
            var list = ctx.getElementsByTagName(tagName),
                i = 0,
                n = list.length;

            if (iterator) {
                for (; i < n; i++) {
                    iterator(list[i], i);
                }
            }

            return list;
        }

        return [];
    }

    function _dispatchEvent(sortable, rootEl, name, targetEl, toEl, fromEl, startIndex, newIndex) {
        sortable = sortable || rootEl[expando];

        var evt = document.createEvent('Event'),
            options = sortable.options,
            onName = 'on' + name.charAt(0).toUpperCase() + name.substr(1);

        evt.initEvent(name, true, true);

        evt.to = toEl || rootEl;
        evt.from = fromEl || rootEl;
        evt.item = targetEl || rootEl;
        evt.clone = cloneEl;

        evt.oldIndex = startIndex;
        evt.newIndex = newIndex;

        rootEl.dispatchEvent(evt);

        if (options[onName]) {
            options[onName].call(sortable, evt);
        }
    }

    function _onMove(fromEl, toEl, dragEl, dragRect, targetEl, targetRect, originalEvt, willInsertAfter) {
        var evt,
            sortable = fromEl[expando],
            onMoveFn = sortable.options.onMove,
            retVal;

        evt = document.createEvent('Event');
        evt.initEvent('move', true, true);

        evt.to = toEl;
        evt.from = fromEl;
        evt.dragged = dragEl;
        evt.draggedRect = dragRect;
        evt.related = targetEl || toEl;
        evt.relatedRect = targetRect || toEl.getBoundingClientRect();
        evt.willInsertAfter = willInsertAfter;

        fromEl.dispatchEvent(evt);

        if (onMoveFn) {
            retVal = onMoveFn.call(sortable, evt, originalEvt);
        }

        return retVal;
    }

    function _disableDraggable(el) {
        el.draggable = false;
    }

    function _unsilent() {
        _silent = false;
    }

    /** @returns {HTMLElement|false} */
    function _ghostIsLast(el, evt) {
        var lastEl = el.lastElementChild,
            rect = lastEl.getBoundingClientRect();

        // 5 — min delta
        // abs — нельзя добавлять, а то глюки при наведении сверху
        return evt.clientY - (rect.top + rect.height) > 5 || evt.clientX - (rect.left + rect.width) > 5;
    }

    /**
     * Generate id
     * @param   {HTMLElement} el
     * @returns {String}
     * @private
     */
    function _generateId(el) {
        var str = el.tagName + el.className + el.src + el.href + el.textContent,
            i = str.length,
            sum = 0;

        while (i--) {
            sum += str.charCodeAt(i);
        }

        return sum.toString(36);
    }

    /**
     * Returns the index of an element within its parent for a selected set of
     * elements
     * @param  {HTMLElement} el
     * @param  {selector} selector
     * @return {number}
     */
    function _index(el, selector) {
        var index = 0;

        if (!el || !el.parentNode) {
            return -1;
        }

        while (el && (el = el.previousElementSibling)) {
            if (el.nodeName.toUpperCase() !== 'TEMPLATE' && (selector === '>*' || _matches(el, selector))) {
                index++;
            }
        }

        return index;
    }

    function _matches( /**HTMLElement*/el, /**String*/selector) {
        if (el) {
            selector = selector.split('.');

            var tag = selector.shift().toUpperCase(),
                re = new RegExp('\\s(' + selector.join('|') + ')(?=\\s)', 'g');

            return (tag === '' || el.nodeName.toUpperCase() == tag) && (!selector.length || ((' ' + el.className + ' ').match(re) || []).length == selector.length);
        }

        return false;
    }

    function _throttle(callback, ms) {
        var args, _this;

        return function () {
            if (args === void 0) {
                args = arguments;
                _this = this;

                setTimeout(function () {
                    if (args.length === 1) {
                        callback.call(_this, args[0]);
                    } else {
                        callback.apply(_this, args);
                    }

                    args = void 0;
                }, ms);
            }
        };
    }

    function _extend(dst, src) {
        if (dst && src) {
            for (var key in src) {
                if (src.hasOwnProperty(key)) {
                    dst[key] = src[key];
                }
            }
        }

        return dst;
    }

    function _clone(el) {
        if (Polymer && Polymer.dom) {
            return Polymer.dom(el).cloneNode(true);
        } else if ($) {
            return $(el).clone(true)[0];
        } else {
            return el.cloneNode(true);
        }
    }

    function _saveInputCheckedState(root) {
        var inputs = root.getElementsByTagName('input');
        var idx = inputs.length;

        while (idx--) {
            var el = inputs[idx];
            el.checked && savedInputChecked.push(el);
        }
    }

    function _nextTick(fn) {
        return setTimeout(fn, 0);
    }

    function _cancelNextTick(id) {
        return clearTimeout(id);
    }

    // Fixed #973:
    _on(document, 'touchmove', function (evt) {
        if (Sortable.active) {
            evt.preventDefault();
        }
    });

    // Export utils
    Sortable.utils = {
        on: _on,
        off: _off,
        css: _css,
        find: _find,
        is: function (el, selector) {
            return !!_closest(el, selector, el);
        },
        extend: _extend,
        throttle: _throttle,
        closest: _closest,
        toggleClass: _toggleClass,
        clone: _clone,
        index: _index,
        nextTick: _nextTick,
        cancelNextTick: _cancelNextTick
    };

    /**
     * Create sortable instance
     * @param {HTMLElement}  el
     * @param {Object}      [options]
     */
    Sortable.create = function (el, options) {
        return new Sortable(el, options);
    };

    // Export
    Sortable.version = '1.7.0';
    return Sortable;
});

/*! npm.im/object-fit-images 3.2.3 */
var objectFitImages = function () {
    'use strict';

    var OFI = 'bfred-it:object-fit-images';
    var propRegex = /(object-fit|object-position)\s*:\s*([-\w\s%]+)/g;
    var testImg = typeof Image === 'undefined' ? { style: { 'object-position': 1 } } : new Image();
    var supportsObjectFit = 'object-fit' in testImg.style;
    var supportsObjectPosition = 'object-position' in testImg.style;
    var supportsOFI = 'background-size' in testImg.style;
    var supportsCurrentSrc = typeof testImg.currentSrc === 'string';
    var nativeGetAttribute = testImg.getAttribute;
    var nativeSetAttribute = testImg.setAttribute;
    var autoModeEnabled = false;

    function createPlaceholder(w, h) {
        return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='" + w + "' height='" + h + "'%3E%3C/svg%3E";
    }

    function polyfillCurrentSrc(el) {
        if (el.srcset && !supportsCurrentSrc && window.picturefill) {
            var pf = window.picturefill._;
            // parse srcset with picturefill where currentSrc isn't available
            if (!el[pf.ns] || !el[pf.ns].evaled) {
                // force synchronous srcset parsing
                pf.fillImg(el, { reselect: true });
            }

            if (!el[pf.ns].curSrc) {
                // force picturefill to parse srcset
                el[pf.ns].supported = false;
                pf.fillImg(el, { reselect: true });
            }

            // retrieve parsed currentSrc, if any
            el.currentSrc = el[pf.ns].curSrc || el.src;
        }
    }

    function getStyle(el) {
        var style = getComputedStyle(el).fontFamily;
        var parsed;
        var props = {};
        while ((parsed = propRegex.exec(style)) !== null) {
            props[parsed[1]] = parsed[2];
        }
        return props;
    }

    function setPlaceholder(img, width, height) {
        // Default: fill width, no height
        var placeholder = createPlaceholder(width || 1, height || 0);

        // Only set placeholder if it's different
        if (nativeGetAttribute.call(img, 'src') !== placeholder) {
            nativeSetAttribute.call(img, 'src', placeholder);
        }
    }

    function onImageReady(img, callback) {
        // naturalWidth is only available when the image headers are loaded,
        // this loop will poll it every 100ms.
        if (img.naturalWidth) {
            callback(img);
        } else {
            setTimeout(onImageReady, 100, img, callback);
        }
    }

    function fixOne(el) {
        var style = getStyle(el);
        var ofi = el[OFI];
        style['object-fit'] = style['object-fit'] || 'fill'; // default value

        // Avoid running where unnecessary, unless OFI had already done its deed
        if (!ofi.img) {
            // fill is the default behavior so no action is necessary
            if (style['object-fit'] === 'fill') {
                return;
            }

            // Where object-fit is supported and object-position isn't (Safari < 10)
            if (!ofi.skipTest && // unless user wants to apply regardless of browser support
            supportsObjectFit && // if browser already supports object-fit
            !style['object-position'] // unless object-position is used
            ) {
                    return;
                }
        }

        // keep a clone in memory while resetting the original to a blank
        if (!ofi.img) {
            ofi.img = new Image(el.width, el.height);
            ofi.img.srcset = nativeGetAttribute.call(el, "data-ofi-srcset") || el.srcset;
            ofi.img.src = nativeGetAttribute.call(el, "data-ofi-src") || el.src;

            // preserve for any future cloneNode calls
            // https://github.com/bfred-it/object-fit-images/issues/53
            nativeSetAttribute.call(el, "data-ofi-src", el.src);
            if (el.srcset) {
                nativeSetAttribute.call(el, "data-ofi-srcset", el.srcset);
            }

            setPlaceholder(el, el.naturalWidth || el.width, el.naturalHeight || el.height);

            // remove srcset because it overrides src
            if (el.srcset) {
                el.srcset = '';
            }
            try {
                keepSrcUsable(el);
            } catch (err) {
                if (window.console) {
                    console.warn('https://bit.ly/ofi-old-browser');
                }
            }
        }

        polyfillCurrentSrc(ofi.img);

        el.style.backgroundImage = "url(\"" + (ofi.img.currentSrc || ofi.img.src).replace(/"/g, '\\"') + "\")";
        el.style.backgroundPosition = style['object-position'] || 'center';
        el.style.backgroundRepeat = 'no-repeat';
        el.style.backgroundOrigin = 'content-box';

        if (/scale-down/.test(style['object-fit'])) {
            onImageReady(ofi.img, function () {
                if (ofi.img.naturalWidth > el.width || ofi.img.naturalHeight > el.height) {
                    el.style.backgroundSize = 'contain';
                } else {
                    el.style.backgroundSize = 'auto';
                }
            });
        } else {
            el.style.backgroundSize = style['object-fit'].replace('none', 'auto').replace('fill', '100% 100%');
        }

        onImageReady(ofi.img, function (img) {
            setPlaceholder(el, img.naturalWidth, img.naturalHeight);
        });
    }

    function keepSrcUsable(el) {
        var descriptors = {
            get: function get(prop) {
                return el[OFI].img[prop ? prop : 'src'];
            },
            set: function set(value, prop) {
                el[OFI].img[prop ? prop : 'src'] = value;
                nativeSetAttribute.call(el, "data-ofi-" + prop, value); // preserve for any future cloneNode
                fixOne(el);
                return value;
            }
        };
        Object.defineProperty(el, 'src', descriptors);
        Object.defineProperty(el, 'currentSrc', {
            get: function () {
                return descriptors.get('currentSrc');
            }
        });
        Object.defineProperty(el, 'srcset', {
            get: function () {
                return descriptors.get('srcset');
            },
            set: function (ss) {
                return descriptors.set(ss, 'srcset');
            }
        });
    }

    function hijackAttributes() {
        function getOfiImageMaybe(el, name) {
            return el[OFI] && el[OFI].img && (name === 'src' || name === 'srcset') ? el[OFI].img : el;
        }
        if (!supportsObjectPosition) {
            HTMLImageElement.prototype.getAttribute = function (name) {
                return nativeGetAttribute.call(getOfiImageMaybe(this, name), name);
            };

            HTMLImageElement.prototype.setAttribute = function (name, value) {
                return nativeSetAttribute.call(getOfiImageMaybe(this, name), name, String(value));
            };
        }
    }

    function fix(imgs, opts) {
        var startAutoMode = !autoModeEnabled && !imgs;
        opts = opts || {};
        imgs = imgs || 'img';

        if (supportsObjectPosition && !opts.skipTest || !supportsOFI) {
            return false;
        }

        // use imgs as a selector or just select all images
        if (imgs === 'img') {
            imgs = document.getElementsByTagName('img');
        } else if (typeof imgs === 'string') {
            imgs = document.querySelectorAll(imgs);
        } else if (!('length' in imgs)) {
            imgs = [imgs];
        }

        // apply fix to all
        for (var i = 0; i < imgs.length; i++) {
            imgs[i][OFI] = imgs[i][OFI] || {
                skipTest: opts.skipTest
            };
            fixOne(imgs[i]);
        }

        if (startAutoMode) {
            document.body.addEventListener('load', function (e) {
                if (e.target.tagName === 'IMG') {
                    fix(e.target, {
                        skipTest: opts.skipTest
                    });
                }
            }, true);
            autoModeEnabled = true;
            imgs = 'img'; // reset to a generic selector for watchMQ
        }

        // if requested, watch media queries for object-fit change
        if (opts.watchMQ) {
            window.addEventListener('resize', fix.bind(null, imgs, {
                skipTest: opts.skipTest
            }));
        }
    }

    fix.supportsObjectFit = supportsObjectFit;
    fix.supportsObjectPosition = supportsObjectPosition;

    hijackAttributes();

    return fix;
}();

(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() : typeof define === 'function' && define.amd ? define(factory) : global.reframe = factory();
})(this, function () {
    'use strict';

    function reframe(target, cName) {
        var frames = typeof target === 'string' ? document.querySelectorAll(target) : target;
        var c = cName || 'js-reframe';
        if (!('length' in frames)) frames = [frames];
        for (var i = 0; i < frames.length; i += 1) {
            var frame = frames[i];
            var hasClass = frame.className.split(' ').indexOf(c) !== -1;
            if (hasClass) return;
            var hAttr = frame.getAttribute('height');
            var wAttr = frame.getAttribute('width');
            if (wAttr.indexOf('%') > -1 || frame.style.width.indexOf('%') > -1) return;
            var h = hAttr ? hAttr : frame.offsetHeight;
            var w = wAttr ? wAttr : frame.offsetWidth;
            var padding = h / w * 100;
            var div = document.createElement('div');
            div.className = c;
            var divStyles = div.style;
            divStyles.position = 'relative';
            divStyles.width = '100%';
            divStyles.paddingTop = padding + '%';
            var frameStyle = frame.style;
            frameStyle.position = 'absolute';
            frameStyle.width = '100%';
            frameStyle.height = '100%';
            frameStyle.left = '0';
            frameStyle.top = '0';
            frame.parentNode.insertBefore(div, frame);
            frame.parentNode.removeChild(frame);
            div.appendChild(frame);
        }
    }

    return reframe;
});

(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() : typeof define === 'function' && define.amd ? define(factory) : global.noframe = factory();
})(this, function () {
    'use strict';

    function noframe(target, container) {
        var frames = typeof target === 'string' ? document.querySelectorAll(target) : target;
        if (!('length' in frames)) frames = [frames];
        for (var i = 0; i < frames.length; i += 1) {
            var frame = frames[i];
            var isContainerElement = typeof container !== 'undefined' && document.querySelector(container);
            var parent = isContainerElement ? document.querySelector(container) : frame.parentElement;
            var h = frame.offsetHeight;
            var w = frame.offsetWidth;
            var styles = frame.style;
            var maxW = w + 'px';
            if (isContainerElement) {
                maxW = window.getComputedStyle(parent, null).getPropertyValue('max-width');
                styles.width = '100%';
                styles.maxHeight = 'calc(' + maxW + ' * ' + h + ' / ' + w + ')';
            } else {
                var maxH = void 0;
                styles.display = 'block';
                styles.marginLeft = 'auto';
                styles.marginRight = 'auto';
                var fullW = maxW;
                if (w > parent.offsetWidth) {
                    fullW = parent.offsetWidth;
                    maxH = fullW * h / w;
                } else maxH = w * (h / w);
                styles.maxHeight = maxH + 'px';
                styles.width = fullW;
            }
            var cssHeight = 100 * h / w;
            styles.height = cssHeight + 'vw';
            styles.maxWidth = '100%';
        }
    }

    return noframe;
});

(function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define('GLightbox', ['module'], factory);
    } else if (typeof exports !== "undefined") {
        factory(module);
    } else {
        var mod = {
            exports: {}
        };
        factory(mod);
        global.GLightbox = mod.exports;
    }
})(this, function (module) {
    'use strict';

    function _classCallCheck(instance, Constructor) {
        if (!(instance instanceof Constructor)) {
            throw new TypeError("Cannot call a class as a function");
        }
    }

    var _createClass = function () {
        function defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
                var descriptor = props[i];
                descriptor.enumerable = descriptor.enumerable || false;
                descriptor.configurable = true;
                if ("value" in descriptor) descriptor.writable = true;
                Object.defineProperty(target, descriptor.key, descriptor);
            }
        }

        return function (Constructor, protoProps, staticProps) {
            if (protoProps) defineProperties(Constructor.prototype, protoProps);
            if (staticProps) defineProperties(Constructor, staticProps);
            return Constructor;
        };
    }();

    var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
        return typeof obj;
    } : function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };

    /**
     * GLightbox v1.0.6
     * Awesome pure javascript lightbox
     * made by mcstudios.com.mx
     */

    var isMobile = navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i);
    var isTouch = isMobile !== null || document.createTouch !== undefined || 'ontouchstart' in window || 'onmsgesturechange' in window || navigator.msMaxTouchPoints;
    var html = document.getElementsByTagName('html')[0];
    var body = document.body;
    var transitionEnd = whichTransitionEvent();
    var animationEnd = whichAnimationEvent();

    var YTTemp = [];
    var videoPlayers = {};

    // Default settings
    var defaults = {
        selector: 'glightbox',
        skin: 'clean',
        closeButton: true,
        startAt: 0,
        autoplayVideos: true,
        descPosition: 'bottom',
        width: 900,
        height: 506,
        videosWidth: 900,
        videosHeight: 506,
        beforeSlideChange: null,
        afterSlideChange: null,
        beforeSlideLoad: null,
        afterSlideLoad: null,
        onOpen: null,
        onClose: null,
        loopAtEnd: false,
        touchNavigation: true,
        keyboardNavigation: true,
        closeOnOutsideClick: true,
        jwplayer: {
            api: null,
            licenseKey: null,
            params: {
                width: '100%',
                aspectratio: '16:9',
                stretching: 'uniform'
            }
        },
        vimeo: {
            api: 'https://player.vimeo.com/api/player.js',
            params: {
                api: 1,
                title: 0,
                byline: 0,
                portrait: 0
            }
        },
        youtube: {
            api: 'https://www.youtube.com/iframe_api',
            params: {
                enablejsapi: 1,
                showinfo: 0
            }
        },
        openEffect: 'zoomIn', // fade, zoom, none
        closeEffect: 'zoomOut', // fade, zoom, none
        slideEffect: 'slide', // fade, slide, zoom, none
        moreText: 'See more',
        moreLength: 60,
        slideHtml: '',
        lightboxHtml: '',
        cssEfects: {
            fade: { in: 'fadeIn', out: 'fadeOut' },
            zoom: { in: 'zoomIn', out: 'zoomOut' },
            slide: { in: 'slideInRight', out: 'slideOutLeft' },
            slide_back: { in: 'slideInLeft', out: 'slideOutRight' }
        }
    };

    /* jshint multistr: true */
    // You can pass your own slide structure
    // just make sure that add the same classes so they are populated
    // title class = gslide-title
    // desc class = gslide-desc
    // prev arrow class = gnext
    // next arrow id = gprev
    // close id = gclose
    var lightboxSlideHtml = '<div class="gslide">\
         <div class="gslide-inner-content">\
            <div class="ginner-container">\
               <div class="gslide-media">\
               </div>\
               <div class="gslide-description">\
                  <h4 class="gslide-title"></h4>\
                  <div class="gslide-desc"></div>\
               </div>\
            </div>\
         </div>\
       </div>';
    defaults.slideHtml = lightboxSlideHtml;

    var lightboxHtml = '<div id="glightbox-body" class="glightbox-container">\
            <div class="gloader visible"></div>\
            <div class="goverlay"></div>\
            <div class="gcontainer">\
               <div id="glightbox-slider" class="gslider"></div>\
               <a class="gnext"></a>\
               <a class="gprev"></a>\
               <a class="gclose"></a>\
            </div>\
   </div>';
    defaults.lightboxHtml = lightboxHtml;

    /**
     * Merge two or more objects
     */
    function extend() {
        var extended = {};
        var deep = false;
        var i = 0;
        var length = arguments.length;
        if (Object.prototype.toString.call(arguments[0]) === '[object Boolean]') {
            deep = arguments[0];
            i++;
        }
        var merge = function merge(obj) {
            for (var prop in obj) {
                if (Object.prototype.hasOwnProperty.call(obj, prop)) {
                    if (deep && Object.prototype.toString.call(obj[prop]) === '[object Object]') {
                        extended[prop] = extend(true, extended[prop], obj[prop]);
                    } else {
                        extended[prop] = obj[prop];
                    }
                }
            }
        };
        for (; i < length; i++) {
            var obj = arguments[i];
            merge(obj);
        }
        return extended;
    }

    var utils = {
        isFunction: function isFunction(f) {
            return typeof f === 'function';
        },
        isString: function isString(s) {
            return typeof s === 'string';
        },
        isNode: function isNode(el) {
            return !!(el && el.nodeType && el.nodeType == 1);
        },
        isArray: function isArray(ar) {
            return Array.isArray(ar);
        },
        isArrayLike: function isArrayLike(ar) {
            return ar && ar.length && isFinite(ar.length);
        },
        isObject: function isObject(o) {
            var type = typeof o === 'undefined' ? 'undefined' : _typeof(o);
            return type === 'object' && o != null && !utils.isFunction(o) && !utils.isArray(o);
        },
        isNil: function isNil(o) {
            return o == null;
        },
        has: function has(obj, key) {
            return obj !== null && hasOwnProperty.call(obj, key);
        },
        size: function size(o) {
            if (utils.isObject(o)) {
                if (o.keys) {
                    return o.keys().length;
                }
                var l = 0;
                for (var k in o) {
                    if (utils.has(o, k)) {
                        l++;
                    }
                }
                return l;
            } else {
                return o.length;
            }
        },
        isNumber: function isNumber(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }
    };

    /**
     * Each
     *
     * @param {mixed} node lisy, array, object
     * @param {function} callback
     */
    function each(collection, callback) {
        if (utils.isNode(collection) || collection === window || collection === document) {
            collection = [collection];
        }
        if (!utils.isArrayLike(collection) && !utils.isObject(collection)) {
            collection = [collection];
        }
        if (utils.size(collection) == 0) {
            return;
        }

        if (utils.isArrayLike(collection) && !utils.isObject(collection)) {
            var l = collection.length,
                i = 0;
            for (; i < l; i++) {
                if (callback.call(collection[i], collection[i], i, collection) === false) {
                    break;
                }
            }
        } else if (utils.isObject(collection)) {
            for (var key in collection) {
                if (utils.has(collection, key)) {
                    if (callback.call(collection[key], collection[key], key, collection) === false) {
                        break;
                    }
                }
            }
        }
    }

    /**
     * Add Event
     * Add an event listener
     *
     * @param {string} eventName
     * @param {object} detials
     */
    function addEvent(eventName) {
        var _ref = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {},
            onElement = _ref.onElement,
            withCallback = _ref.withCallback,
            _ref$once = _ref.once,
            once = _ref$once === undefined ? false : _ref$once,
            _ref$useCapture = _ref.useCapture,
            useCapture = _ref$useCapture === undefined ? false : _ref$useCapture;

        var thisArg = arguments[2];

        var element = onElement || [];
        if (utils.isString(element)) {
            element = document.querySelectorAll(element);
        }
        function handler(event) {
            if (utils.isFunction(withCallback)) {
                withCallback.call(thisArg, event, this);
            }
            if (once) {
                handler.destroy();
            }
        }
        handler.destroy = function () {
            each(element, function (el) {
                el.removeEventListener(eventName, handler, useCapture);
            });
        };
        each(element, function (el) {
            el.addEventListener(eventName, handler, useCapture);
        });
        return handler;
    }

    /**
     * Add element class
     *
     * @param {node} element
     * @param {string} class name
     */
    function addClass(node, name) {
        if (hasClass(node, name)) {
            return;
        }
        if (node.classList) {
            node.classList.add(name);
        } else {
            node.className += " " + name;
        }
    }

    /**
     * Remove element class
     *
     * @param {node} element
     * @param {string} class name
     */
    function removeClass(node, name) {
        var c = name.split(' ');
        if (c.length > 1) {
            each(c, function (cl) {
                removeClass(node, cl);
            });
            return;
        }
        if (node.classList) {
            node.classList.remove(name);
        } else {
            node.className = node.className.replace(name, "");
        }
    }

    /**
     * Has class
     *
     * @param {node} element
     * @param {string} class name
     */
    function hasClass(node, name) {
        return node.classList ? node.classList.contains(name) : new RegExp("(^| )" + name + "( |$)", "gi").test(node.className);
    }

    /**
     * Determine animation events
     */
    function whichAnimationEvent() {
        var t = void 0,
            el = document.createElement("fakeelement");
        var animations = {
            animation: "animationend",
            OAnimation: "oAnimationEnd",
            MozAnimation: "animationend",
            WebkitAnimation: "webkitAnimationEnd"
        };
        for (t in animations) {
            if (el.style[t] !== undefined) {
                return animations[t];
            }
        }
    }

    /**
     * Determine transition events
     */
    function whichTransitionEvent() {
        var t = void 0,
            el = document.createElement("fakeelement");

        var transitions = {
            transition: "transitionend",
            OTransition: "oTransitionEnd",
            MozTransition: "transitionend",
            WebkitTransition: "webkitTransitionEnd"
        };

        for (t in transitions) {
            if (el.style[t] !== undefined) {
                return transitions[t];
            }
        }
    }

    /**
     * CSS Animations
     *
     * @param {node} element
     * @param {string} animation name
     * @param {function} callback
     */
    function animateElement(element) {
        var animation = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
        var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

        if (!element || animation === '') {
            return false;
        }
        if (animation == 'none') {
            if (utils.isFunction(callback)) callback();
            return false;
        }
        var animationNames = animation.split(' ');
        each(animationNames, function (name) {
            addClass(element, 'g' + name);
        });
        var animationEvent = addEvent(animationEnd, {
            onElement: element,
            once: true,
            withCallback: function withCallback(event, target) {
                each(animationNames, function (name) {
                    removeClass(target, 'g' + name);
                });
                // animation.destroy()
                if (utils.isFunction(callback)) callback();
            }
        });
    }

    /**
     * Create a document fragment
     *
     * @param {string} html code
     */
    function createHTML(htmlStr) {
        var frag = document.createDocumentFragment(),
            temp = document.createElement('div');
        temp.innerHTML = htmlStr;
        while (temp.firstChild) {
            frag.appendChild(temp.firstChild);
        }
        return frag;
    }

    /**
     * Get the closestElement
     *
     * @param {node} element
     * @param {string} class name
     */
    function getClosest(elem, selector) {
        while (elem !== document.body) {
            elem = elem.parentElement;
            if (elem.matches(selector)) return elem;
        }
    }

    /**
     * Show element
     *
     * @param {node} element
     */
    function show(element) {
        element.style.display = 'block';
    }

    /**
     * Hide element
     */
    function hide(element) {
        element.style.display = 'none';
    }

    /**
     * Get slide data
     *
     * @param {node} element
     */
    var getSlideData = function getSlideData() {
        var element = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
        var settings = arguments[1];

        var data = {
            href: '',
            title: '',
            description: '',
            descPosition: 'bottom',
            effect: '',
            node: element
        };

        if (utils.isObject(element) && !utils.isNode(element)) {
            return extend(data, element);
        }

        var url = '';
        var config = element.getAttribute('data-glightbox');
        var type = element.nodeName.toLowerCase();
        if (type === 'a') url = element.href;
        if (type === 'img') url = element.src;

        data.href = url;
        var sourceType = getSourceType(url);
        data = extend(data, sourceType);

        if (!utils.isNil(config)) {
            config = config.replace(/'/g, '\\"');
            if (config.trim() !== '') {
                config = config.split(';');
                config = config.filter(Boolean);
            }
            each(config, function (set) {
                set = set.trim().split(':');
                if (utils.size(set) == 2) {
                    var ckey = set[0].trim();
                    var cvalue = set[1].trim();

                    if (cvalue !== '') {
                        cvalue = cvalue.replace(/\\/g, '');
                    }
                    data[ckey] = cvalue;
                }
            });
        } else {
            if (type == 'a') {
                var title = element.title;
                if (!utils.isNil(title) && title !== '') data.title = title;
            }
            if (type == 'img') {
                var alt = element.alt;
                if (!utils.isNil(alt) && alt !== '') data.title = alt;
            }
            var desc = element.getAttribute('data-description');
            if (!utils.isNil(desc) && desc !== '') data.description = desc;
        }
        var nodeDesc = element.querySelector('.glightbox-desc');
        if (nodeDesc) {
            data.description = nodeDesc.innerHTML;
        }

        data.sourcetype = data.hasOwnProperty('type') ? data.type : data.sourcetype;
        data.type = data.sourcetype;

        var defaultWith = data.sourcetype == 'video' ? settings.videosWidth : settings.width;
        var defaultHeight = data.sourcetype == 'video' ? settings.videosHeight : settings.height;

        data.width = utils.has(data, 'width') ? data.width : defaultWith;
        data.height = utils.has(data, 'height') ? data.height : defaultHeight;

        return data;
    };

    /**
     * Set slide content
     *
     * @param {node} slide
     * @param {object} data
     * @param {function} callback
     */
    var setSlideContent = function setSlideContent() {
        var slide = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;

        var _this = this;

        var data = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        var callback = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

        if (hasClass(slide, 'loaded')) {
            return false;
        }

        if (utils.isFunction(this.settings.beforeSlideLoad)) {
            this.settings.beforeSlideLoad(slide, data);
        }

        var type = data.type;
        var position = data.descPosition;
        var slideMedia = slide.querySelector('.gslide-media');
        var slideTitle = slide.querySelector('.gslide-title');
        var slideText = slide.querySelector('.gslide-desc');
        var slideDesc = slide.querySelector('.gslide-description');
        var finalCallback = callback;

        if (utils.isFunction(this.settings.afterSlideLoad)) {
            finalCallback = function finalCallback() {
                if (utils.isFunction(callback)) {
                    callback();
                }
                _this.settings.afterSlideLoad(slide, data);
            };
        }

        if (data.title == '' && data.description == '') {
            if (slideDesc) {
                slideDesc.parentNode.removeChild(slideDesc);
            }
        } else {
            if (slideTitle && data.title !== '') {
                slideTitle.innerHTML = data.title;
            } else {
                slideTitle.parentNode.removeChild(slideTitle);
            }
            if (slideText && data.description !== '') {
                if (isMobile && this.settings.moreLength > 0) {
                    data.smallDescription = slideShortDesc(data.description, this.settings.moreLength, this.settings.moreText);
                    slideText.innerHTML = data.smallDescription;
                    slideDescriptionEvents.apply(this, [slideText, data]);
                } else {
                    slideText.innerHTML = data.description;
                }
            } else {
                slideText.parentNode.removeChild(slideText);
            }
            addClass(slideMedia.parentNode, 'desc-' + position);
            addClass(slideDesc, 'description-' + position);
        }

        addClass(slideMedia, 'gslide-' + type);
        addClass(slide, 'loaded');

        if (type === 'video') {
            setSlideVideo.apply(this, [slide, data, finalCallback]);
            return;
        }

        if (type === 'external') {
            var iframe = createIframe(data.href, data.width, data.height, finalCallback);
            slideMedia.appendChild(iframe);
            return;
        }

        if (type === 'inline') {
            setInlineContent.apply(this, [slide, data, finalCallback]);
            return;
        }

        if (type === 'image') {
            var img = new Image();
            img.addEventListener('load', function () {
                if (utils.isFunction(finalCallback)) {
                    finalCallback();
                }
            }, false);
            img.src = data.href;
            slideMedia.appendChild(img);
            return;
        }

        if (utils.isFunction(finalCallback)) finalCallback();
    };

    /**
     * Set slide video
     *
     * @param {node} slide
     * @param {object} data
     * @param {function} callback
     */
    function setSlideVideo(slide, data, callback) {
        var _this2 = this;

        var source = data.source;
        var video_id = 'gvideo' + data.index;
        var slideMedia = slide.querySelector('.gslide-media');

        var url = data.href;
        var protocol = location.protocol.replace(':', '');

        if (protocol == 'file') {
            protocol = 'http';
        }

        // Set vimeo videos
        if (source == 'vimeo') {
            var vimeo_id = /vimeo.*\/(\d+)/i.exec(url);
            var params = parseUrlParams(this.settings.vimeo.params);
            var video_url = protocol + '://player.vimeo.com/video/' + vimeo_id[1] + '?' + params;
            var iframe = createIframe(video_url, data.width, data.height, callback);
            iframe.id = video_id;
            iframe.className = 'vimeo-video gvideo';

            if (this.settings.autoplayVideos) {
                iframe.className += ' wait-autoplay';
            }

            injectVideoApi(this.settings.vimeo.api, function () {
                var player = new Vimeo.Player(iframe);
                videoPlayers[video_id] = player;
                slideMedia.appendChild(iframe);
            });
        }

        // Set youtube videos
        if (source == 'youtube') {
            var youtube_params = extend(this.settings.youtube.params, {
                playerapiid: video_id
            });
            var yparams = parseUrlParams(youtube_params);
            var youtube_id = getYoutubeID(url);
            var _video_url = protocol + '://www.youtube.com/embed/' + youtube_id + '?' + yparams;
            var _iframe = createIframe(_video_url, data.width, data.height, callback);
            _iframe.id = video_id;
            _iframe.className = 'youtube-video gvideo';

            if (this.settings.autoplayVideos) {
                _iframe.className += ' wait-autoplay';
            }

            injectVideoApi(this.settings.youtube.api, function () {
                if (!utils.isNil(YT) && YT.loaded) {
                    var player = new YT.Player(_iframe);
                    videoPlayers[video_id] = player;
                } else {
                    YTTemp.push(_iframe);
                }
                slideMedia.appendChild(_iframe);
            });
        }

        if (source == 'local') {
            var _html = '<video id="' + video_id + '" ';
            _html += 'style="background:#000; width: ' + data.width + 'px; height: ' + data.height + 'px;" ';
            _html += 'preload="metadata" ';
            _html += 'x-webkit-airplay="allow" ';
            _html += 'webkit-playsinline="" ';
            _html += 'controls ';
            _html += 'class="gvideo">';

            var format = url.toLowerCase().split('.').pop();
            var sources = { 'mp4': '', 'ogg': '', 'webm': '' };
            sources[format] = url;

            for (var key in sources) {
                if (sources.hasOwnProperty(key)) {
                    var videoFile = sources[key];
                    if (data.hasOwnProperty(key)) {
                        videoFile = data[key];
                    }
                    if (videoFile !== '') {
                        _html += '<source src="' + videoFile + '" type="video/' + key + '">';
                    }
                }
            }

            _html += '</video>';

            var video = createHTML(_html);
            slideMedia.appendChild(video);

            var vnode = document.getElementById(video_id);
            if (this.settings.jwplayer !== null && this.settings.jwplayer.api !== null) {
                var jwplayerConfig = this.settings.jwplayer;
                var jwplayerApi = this.settings.jwplayer.api;

                if (!jwplayerApi) {
                    console.warn('Missing jwplayer api file');
                    if (utils.isFunction(callback)) callback();
                    return false;
                }

                injectVideoApi(jwplayerApi, function () {
                    var jwconfig = extend(_this2.settings.jwplayer.params, {
                        width: _this2.settings.width + 'px',
                        height: _this2.settings.height + 'px',
                        file: url
                    });

                    jwplayer.key = _this2.settings.jwplayer.licenseKey;

                    var player = jwplayer(video_id);

                    player.setup(jwconfig);

                    videoPlayers[video_id] = player;
                    player.on('ready', function () {
                        vnode = slideMedia.querySelector('.jw-video');
                        addClass(vnode, 'gvideo');
                        vnode.id = video_id;
                        if (utils.isFunction(callback)) callback();
                    });
                });
            } else {
                addClass(vnode, 'html5-video');
                videoPlayers[video_id] = vnode;
                if (utils.isFunction(callback)) callback();
            }
        }
    }

    /**
     * Create an iframe element
     *
     * @param {string} url
     * @param {numeric} width
     * @param {numeric} height
     * @param {function} callback
     */
    function createIframe(url, width, height, callback) {
        var iframe = document.createElement('iframe');
        var winWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        iframe.className = 'vimeo-video gvideo';
        iframe.src = url;
        if (isMobile && winWidth < 767) {
            iframe.style.height = '';
        } else {
            iframe.style.height = height + 'px';
        }
        iframe.style.width = width + 'px';
        iframe.setAttribute('allowFullScreen', '');
        iframe.onload = function () {
            addClass(iframe, 'iframe-ready');
            if (utils.isFunction(callback)) {
                callback();
            }
        };
        return iframe;
    }

    /**
     * Get youtube ID
     *
     * @param {string} url
     * @returns {string} video id
     */
    function getYoutubeID(url) {
        var videoID = '';
        url = url.replace(/(>|<)/gi, '').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
        if (url[2] !== undefined) {
            videoID = url[2].split(/[^0-9a-z_\-]/i);
            videoID = videoID[0];
        } else {
            videoID = url;
        }
        return videoID;
    }

    /**
     * Inject videos api
     * used for youtube, vimeo and jwplayer
     *
     * @param {string} url
     * @param {function} callback
     */
    function injectVideoApi(url, callback) {
        if (utils.isNil(url)) {
            console.error('Inject videos api error');
            return;
        }
        var found = document.querySelectorAll('script[src="' + url + '"]');
        if (utils.isNil(found) || found.length == 0) {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = url;
            script.onload = function () {
                callback();
            };
            document.body.appendChild(script);
            return false;
        }
        callback();
    }

    /**
     * Handle youtube Api
     * This is a simple fix, when the video
     * is ready sometimes the youtube api is still
     * loading so we can not autoplay or pause
     * we need to listen onYouTubeIframeAPIReady and
     * register the videos if required
     */
    function youtubeApiHandle() {
        for (var i = 0; i < YTTemp.length; i++) {
            var iframe = YTTemp[i];
            var player = new YT.Player(iframe);
            videoPlayers[iframe.id] = player;
        }
    }
    if (typeof window.onYouTubeIframeAPIReady !== 'undefined') {
        window.onYouTubeIframeAPIReady = function () {
            window.onYouTubeIframeAPIReady();
            youtubeApiHandle();
        };
    } else {
        window.onYouTubeIframeAPIReady = youtubeApiHandle;
    }

    /**
     * Parse url params
     * convert an object in to a
     * url query string parameters
     *
     * @param {object} params
     */
    function parseUrlParams(params) {
        var qs = '';
        var i = 0;
        each(params, function (val, key) {
            if (i > 0) {
                qs += '&amp;';
            }
            qs += key + '=' + val;
            i += 1;
        });
        return qs;
    }

    /**
     * Set slide inline content
     * we'll extend this to make http
     * requests using the fetch api
     * but for now we keep it simple
     *
     * @param {node} slide
     * @param {object} data
     * @param {function} callback
     */
    function setInlineContent(slide, data, callback) {
        var slideMedia = slide.querySelector('.gslide-media');
        var div = document.getElementById(data.inlined.replace('#', ''));
        if (div) {
            var cloned = div.cloneNode(true);
            cloned.style.height = data.height + 'px';
            cloned.style.maxWidth = data.width + 'px';
            addClass(cloned, 'ginlined-content');
            slideMedia.appendChild(cloned);

            if (utils.isFunction(callback)) {
                callback();
            }
            return;
        }
    }

    /**
     * Get source type
     * gte the source type of a url
     *
     * @param {string} url
     */
    var getSourceType = function getSourceType(url) {
        var origin = url;
        url = url.toLowerCase();
        var data = {};
        if (url.match(/\.(jpeg|jpg|gif|png)$/) !== null) {
            data.sourcetype = 'image';
            return data;
        }
        if (url.match(/(youtube\.com|youtube-nocookie\.com)\/watch\?v=([a-zA-Z0-9\-_]+)/) || url.match(/youtu\.be\/([a-zA-Z0-9\-_]+)/)) {
            data.sourcetype = 'video';
            data.source = 'youtube';
            return data;
        }
        if (url.match(/vimeo\.com\/([0-9]*)/)) {
            data.sourcetype = 'video';
            data.source = 'vimeo';
            return data;
        }
        if (url.match(/\.(mp4|ogg|webm)$/) !== null) {
            data.sourcetype = 'video';
            data.source = 'local';
            return data;
        }

        // Check if inline content
        if (url.indexOf("#") > -1) {
            var hash = origin.split('#').pop();
            if (hash.trim() !== '') {
                data.sourcetype = 'inline';
                data.source = url;
                data.inlined = '#' + hash;
                return data;
            }
        }
        // Ajax
        if (url.includes("gajax=true")) {
            data.sourcetype = 'ajax';
            data.source = url;
        }

        // Any other url
        data.sourcetype = 'external';
        data.source = url;
        return data;
    };

    /**
     * Desktop keyboard navigation
     */
    function keyboardNavigation() {
        var _this3 = this;

        if (this.events.hasOwnProperty('keyboard')) {
            return false;
        }
        this.events['keyboard'] = addEvent('keydown', {
            onElement: window,
            withCallback: function withCallback(event, target) {
                event = event || window.event;
                var key = event.keyCode;
                if (key == 39) _this3.nextSlide();
                if (key == 37) _this3.prevSlide();
                if (key == 27) _this3.close();
            }
        });
    }

    /**
     * Touch navigation
     */
    function touchNavigation() {
        var _this4 = this;

        if (this.events.hasOwnProperty('touchStart')) {
            return false;
        }
        var index = void 0,
            hDistance = void 0,
            vDistance = void 0,
            hDistanceLast = void 0,
            vDistanceLast = void 0,
            hDistancePercent = void 0,
            vSwipe = false,
            hSwipe = false,
            hSwipMinDistance = 0,
            vSwipMinDistance = 0,
            doingPinch = false,
            pinchBigger = false,
            startCoords = {},
            endCoords = {},
            slider = this.slidesContainer,
            activeSlide = null,
            xDown = 0,
            yDown = 0,
            activeSlideImage = null,
            activeSlideMedia = null,
            activeSlideDesc = null;

        var winWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        var winHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        this.events['doctouchmove'] = addEvent('touchmove', {
            onElement: document,
            withCallback: function withCallback(e, target) {
                if (hasClass(body, 'gdesc-open')) {
                    e.preventDefault();
                    return false;
                }
            }
        });

        this.events['touchStart'] = addEvent('touchstart', {
            onElement: body,
            withCallback: function withCallback(e, target) {
                if (hasClass(body, 'gdesc-open')) {
                    return;
                }
                addClass(body, 'touching');
                activeSlide = _this4.getActiveSlide();
                activeSlideImage = activeSlide.querySelector('.gslide-image');
                activeSlideMedia = activeSlide.querySelector('.gslide-media');
                activeSlideDesc = activeSlide.querySelector('.gslide-description');

                index = _this4.index;
                endCoords = e.targetTouches[0];
                startCoords.pageX = e.targetTouches[0].pageX;
                startCoords.pageY = e.targetTouches[0].pageY;
                xDown = e.targetTouches[0].clientX;
                yDown = e.targetTouches[0].clientY;
            }
        });

        this.events['gestureStart'] = addEvent('gesturestart', {
            onElement: body,
            withCallback: function withCallback(e, target) {
                if (activeSlideImage) {
                    e.preventDefault();
                    doingPinch = true;
                }
            }
        });

        this.events['gestureChange'] = addEvent('gesturechange', {
            onElement: body,
            withCallback: function withCallback(e, target) {
                e.preventDefault();
                slideCSSTransform(activeSlideImage, 'scale(' + e.scale + ')');
            }
        });

        this.events['gesturEend'] = addEvent('gestureend', {
            onElement: body,
            withCallback: function withCallback(e, target) {
                doingPinch = false;
                if (e.scale < 1) {
                    pinchBigger = false;
                    slideCSSTransform(activeSlideImage, 'scale(1)');
                } else {
                    pinchBigger = true;
                }
            }
        });

        this.events['touchMove'] = addEvent('touchmove', {
            onElement: body,
            withCallback: function withCallback(e, target) {
                if (!hasClass(body, 'touching')) {
                    return;
                }
                if (hasClass(body, 'gdesc-open') || doingPinch || pinchBigger) {
                    return;
                }
                e.preventDefault();
                endCoords = e.targetTouches[0];
                var slideHeight = activeSlide.querySelector('.gslide-inner-content').offsetHeight;
                var slideWidth = activeSlide.querySelector('.gslide-inner-content').offsetWidth;

                var xUp = e.targetTouches[0].clientX;
                var yUp = e.targetTouches[0].clientY;
                var xDiff = xDown - xUp;
                var yDiff = yDown - yUp;

                if (Math.abs(xDiff) > Math.abs(yDiff)) {
                    /*most significant*/
                    vSwipe = false;
                    hSwipe = true;
                } else {
                    hSwipe = false;
                    vSwipe = true;
                }

                if (vSwipe) {
                    vDistanceLast = vDistance;
                    vDistance = endCoords.pageY - startCoords.pageY;
                    if (Math.abs(vDistance) >= vSwipMinDistance || vSwipe) {
                        var opacity = 0.75 - Math.abs(vDistance) / slideHeight;
                        activeSlideMedia.style.opacity = opacity;
                        if (activeSlideDesc) {
                            activeSlideDesc.style.opacity = opacity;
                        }
                        slideCSSTransform(activeSlideMedia, 'translate3d(0, ' + vDistance + 'px, 0)');
                    }
                    return;
                }

                hDistanceLast = hDistance;
                hDistance = endCoords.pageX - startCoords.pageX;
                hDistancePercent = hDistance * 100 / winWidth;

                if (hSwipe) {
                    if (_this4.index + 1 == _this4.elements.length && hDistance < -60) {
                        resetSlideMove(activeSlide);
                        return false;
                    }
                    if (_this4.index - 1 < 0 && hDistance > 60) {
                        resetSlideMove(activeSlide);
                        return false;
                    }

                    var _opacity = 0.75 - Math.abs(hDistance) / slideWidth;
                    activeSlideMedia.style.opacity = _opacity;
                    if (activeSlideDesc) {
                        activeSlideDesc.style.opacity = _opacity;
                    }
                    slideCSSTransform(activeSlideMedia, 'translate3d(' + hDistancePercent + '%, 0, 0)');
                }
            }
        });

        this.events['touchEnd'] = addEvent('touchend', {
            onElement: body,
            withCallback: function withCallback(e, target) {
                vDistance = endCoords.pageY - startCoords.pageY;
                hDistance = endCoords.pageX - startCoords.pageX;
                hDistancePercent = hDistance * 100 / winWidth;

                removeClass(body, 'touching');

                var slideHeight = activeSlide.querySelector('.gslide-inner-content').offsetHeight;
                var slideWidth = activeSlide.querySelector('.gslide-inner-content').offsetWidth;

                // Swipe to top/bottom to close
                if (vSwipe) {
                    var onEnd = slideHeight / 2;
                    vSwipe = false;
                    if (Math.abs(vDistance) >= onEnd) {
                        _this4.close();
                        return;
                    }
                    resetSlideMove(activeSlide);
                    return;
                }

                if (hSwipe) {
                    hSwipe = false;
                    var where = 'prev';
                    var asideExist = true;
                    if (hDistance < 0) {
                        where = 'next';
                        hDistance = Math.abs(hDistance);
                    }
                    if (where == 'prev' && _this4.index - 1 < 0) {
                        asideExist = false;
                    }
                    if (where == 'next' && _this4.index + 1 >= _this4.elements.length) {
                        asideExist = false;
                    }
                    if (asideExist && hDistance >= slideWidth / 2 - 90) {
                        if (where == 'next') {
                            _this4.nextSlide();
                        } else {
                            _this4.prevSlide();
                        }
                        return;
                    }
                    resetSlideMove(activeSlide);
                }
            }
        });
    }

    function slideCSSTransform(slide) {
        var translate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';

        if (translate == '') {
            slide.style.webkitTransform = '';
            slide.style.MozTransform = '';
            slide.style.msTransform = '';
            slide.style.OTransform = '';
            slide.style.transform = '';
            return false;
        }
        slide.style.webkitTransform = translate;
        slide.style.MozTransform = translate;
        slide.style.msTransform = translate;
        slide.style.OTransform = translate;
        slide.style.transform = translate;
    }

    function resetSlideMove(slide) {
        var media = slide.querySelector('.gslide-media');
        var desc = slide.querySelector('.gslide-description');

        addClass(media, 'greset');
        slideCSSTransform(media, 'translate3d(0, 0, 0)');
        var animation = addEvent(transitionEnd, {
            onElement: media,
            once: true,
            withCallback: function withCallback(event, target) {
                removeClass(media, 'greset');
            }
        });

        media.style.opacity = '';
        if (desc) {
            desc.style.opacity = '';
        }
    }

    function slideShortDesc(string) {
        var n = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 50;
        var wordBoundary = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

        var useWordBoundary = wordBoundary;
        string = string.trim();
        if (string.length <= n) {
            return string;
        }
        var subString = string.substr(0, n - 1);
        if (!useWordBoundary) {
            return subString;
        }
        return subString + '... <a href="#" class="desc-more">' + wordBoundary + '</a>';
    }

    function slideDescriptionEvents(desc, data) {
        var moreLink = desc.querySelector('.desc-more');
        if (!moreLink) {
            return false;
        }

        addEvent('click', {
            onElement: moreLink,
            withCallback: function withCallback(event, target) {
                event.preventDefault();
                var desc = getClosest(target, '.gslide-desc');
                if (!desc) {
                    return false;
                }

                desc.innerHTML = data.description;
                addClass(body, 'gdesc-open');

                var shortEvent = addEvent('click', {
                    onElement: [body, getClosest(desc, '.gslide-description')],
                    withCallback: function withCallback(event, target) {
                        if (event.target.nodeName.toLowerCase() !== 'a') {
                            removeClass(body, 'gdesc-open');
                            addClass(body, 'gdesc-closed');
                            desc.innerHTML = data.smallDescription;
                            slideDescriptionEvents(desc, data);

                            setTimeout(function () {
                                removeClass(body, 'gdesc-closed');
                            }, 400);
                            shortEvent.destroy();
                        }
                    }
                });
            }
        });
    }

    /**
     * GLightbox Class
     * Class and public methods
     */

    var GlightboxInit = function () {
        function GlightboxInit(options) {
            _classCallCheck(this, GlightboxInit);

            this.settings = extend(defaults, options || {});
            this.effectsClasses = this.getAnimationClasses();
        }

        _createClass(GlightboxInit, [{
            key: 'init',
            value: function init() {
                var _this5 = this;

                this.baseEvents = addEvent('click', {
                    onElement: '.' + this.settings.selector,
                    withCallback: function withCallback(e, target) {
                        e.preventDefault();
                        _this5.open(target);
                    }
                });
            }
        }, {
            key: 'open',
            value: function open() {
                var element = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;

                this.elements = this.getElements(element);
                if (this.elements.length == 0) return false;

                this.activeSlide = null;
                this.prevActiveSlideIndex = null;
                this.prevActiveSlide = null;
                var index = this.settings.startAt;
                if (element) {
                    // if element passed, get the index
                    index = this.elements.indexOf(element);
                    if (index < 0) {
                        index = 0;
                    }
                }

                this.build();
                animateElement(this.overlay, this.settings.openEffect == 'none' ? 'none' : this.settings.cssEfects.fade.in);

                var bodyWidth = body.offsetWidth;
                body.style.width = bodyWidth + 'px';

                addClass(body, 'glightbox-open');
                addClass(html, 'glightbox-open');
                if (isMobile) {
                    addClass(html, 'glightbox-mobile');
                    this.settings.slideEffect = 'slide';
                }

                this.showSlide(index, true);

                if (this.elements.length == 1) {
                    hide(this.prevButton);
                    hide(this.nextButton);
                } else {
                    show(this.prevButton);
                    show(this.nextButton);
                }
                this.lightboxOpen = true;

                if (utils.isFunction(this.settings.onOpen)) {
                    this.settings.onOpen();
                }

                if (isMobile && isTouch && this.settings.touchNavigation) {
                    touchNavigation.apply(this);
                    return false;
                }
                if (this.settings.keyboardNavigation) {
                    keyboardNavigation.apply(this);
                }
            }
        }, {
            key: 'showSlide',
            value: function showSlide() {
                var _this6 = this;

                var index = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
                var first = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

                show(this.loader);
                this.index = index;

                var current = this.slidesContainer.querySelector('.current');
                if (current) {
                    removeClass(current, 'current');
                }

                // hide prev slide
                this.slideAnimateOut();

                var slide = this.slidesContainer.querySelectorAll('.gslide')[index];
                show(this.slidesContainer);

                // Check if slide's content is alreay loaded
                if (hasClass(slide, 'loaded')) {
                    this.slideAnimateIn(slide, first);
                    hide(this.loader);
                } else {
                    // If not loaded add the slide content
                    show(this.loader);
                    var slide_data = getSlideData(this.elements[index], this.settings);
                    slide_data.index = index;
                    setSlideContent.apply(this, [slide, slide_data, function () {
                        hide(_this6.loader);
                        _this6.slideAnimateIn(slide, first);
                    }]);
                }

                // Preload subsequent slides
                this.preloadSlide(index + 1);
                this.preloadSlide(index - 1);

                // Handle navigation arrows
                removeClass(this.nextButton, 'disabled');
                removeClass(this.prevButton, 'disabled');
                if (index === 0) {
                    addClass(this.prevButton, 'disabled');
                } else if (index === this.elements.length - 1 && this.settings.loopAtEnd !== true) {
                    addClass(this.nextButton, 'disabled');
                }
                this.activeSlide = slide;
            }
        }, {
            key: 'preloadSlide',
            value: function preloadSlide(index) {
                var _this7 = this;

                // Verify slide index, it can not be lower than 0
                // and it can not be greater than the total elements
                if (index < 0 || index > this.elements.length) return false;

                if (utils.isNil(this.elements[index])) return false;

                var slide = this.slidesContainer.querySelectorAll('.gslide')[index];
                if (hasClass(slide, 'loaded')) {
                    return false;
                }

                var slide_data = getSlideData(this.elements[index], this.settings);
                slide_data.index = index;
                var type = slide_data.sourcetype;
                if (type == 'video' || type == 'external') {
                    setTimeout(function () {
                        setSlideContent.apply(_this7, [slide, slide_data]);
                    }, 200);
                } else {
                    setSlideContent.apply(this, [slide, slide_data]);
                }
            }
        }, {
            key: 'prevSlide',
            value: function prevSlide() {
                var prev = this.index - 1;
                if (prev < 0) {
                    return false;
                }
                this.goToSlide(prev);
            }
        }, {
            key: 'nextSlide',
            value: function nextSlide() {
                var next = this.index + 1;
                if (next > this.elements.length) return false;

                this.goToSlide(next);
            }
        }, {
            key: 'goToSlide',
            value: function goToSlide() {
                var index = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

                if (index > -1) {
                    this.prevActiveSlide = this.activeSlide;
                    this.prevActiveSlideIndex = this.index;

                    if (index < this.elements.length) {
                        this.showSlide(index);
                    } else {
                        if (this.settings.loopAtEnd === true) {
                            index = 0;
                            this.showSlide(index);
                        }
                    }
                }
            }
        }, {
            key: 'slideAnimateIn',
            value: function slideAnimateIn(slide, first) {
                var _this8 = this;

                var slideMedia = slide.querySelector('.gslide-media');
                var slideDesc = slide.querySelector('.gslide-description');
                var prevData = {
                    index: this.prevActiveSlideIndex,
                    slide: this.prevActiveSlide
                };
                var nextData = {
                    index: this.index,
                    slide: this.activeSlide
                };
                if (slideMedia.offsetWidth > 0 && slideDesc) {
                    hide(slideDesc);
                    slide.querySelector('.ginner-container').style.maxWidth = slideMedia.offsetWidth + 'px';
                    slideDesc.style.display = '';
                }
                removeClass(slide, this.effectsClasses);
                if (first) {
                    animateElement(slide, this.settings.openEffect, function () {
                        if (!isMobile && _this8.settings.autoplayVideos) {
                            _this8.playSlideVideo(slide);
                        }
                        if (utils.isFunction(_this8.settings.afterSlideChange)) {
                            _this8.settings.afterSlideChange.apply(_this8, [prevData, nextData]);
                        }
                    });
                } else {
                    var effect_name = this.settings.slideEffect;
                    var animIn = effect_name !== 'none' ? this.settings.cssEfects[effect_name].in : effect_name;
                    if (this.prevActiveSlideIndex > this.index) {
                        if (this.settings.slideEffect == 'slide') {
                            animIn = this.settings.cssEfects.slide_back.in;
                        }
                    }
                    animateElement(slide, animIn, function () {
                        if (!isMobile && _this8.settings.autoplayVideos) {
                            _this8.playSlideVideo(slide);
                        }
                        if (utils.isFunction(_this8.settings.afterSlideChange)) {
                            _this8.settings.afterSlideChange.apply(_this8, [prevData, nextData]);
                        }
                    });
                }
                addClass(slide, 'current');
            }
        }, {
            key: 'slideAnimateOut',
            value: function slideAnimateOut() {
                if (!this.prevActiveSlide) {
                    return false;
                }

                var prevSlide = this.prevActiveSlide;
                removeClass(prevSlide, this.effectsClasses);
                addClass(prevSlide, 'prev');

                var animation = this.settings.slideEffect;
                var animOut = animation !== 'none' ? this.settings.cssEfects[animation].out : animation;

                this.stopSlideVideo(prevSlide);
                if (utils.isFunction(this.settings.beforeSlideChange)) {
                    this.settings.beforeSlideChange.apply(this, [{
                        index: this.prevActiveSlideIndex,
                        slide: this.prevActiveSlide
                    }, {
                        index: this.index,
                        slide: this.activeSlide
                    }]);
                }
                if (this.prevActiveSlideIndex > this.index && this.settings.slideEffect == 'slide') {
                    // going back
                    animOut = this.settings.cssEfects.slide_back.out;
                }
                animateElement(prevSlide, animOut, function () {
                    var media = prevSlide.querySelector('.gslide-media');
                    var desc = prevSlide.querySelector('.gslide-description');

                    media.style.transform = '';
                    removeClass(media, 'greset');
                    media.style.opacity = '';
                    if (desc) {
                        desc.style.opacity = '';
                    }
                    removeClass(prevSlide, 'prev');
                });
            }
        }, {
            key: 'stopSlideVideo',
            value: function stopSlideVideo(slide) {
                if (utils.isNumber(slide)) {
                    slide = this.slidesContainer.querySelectorAll('.gslide')[slide];
                }

                var slideVideo = slide ? slide.querySelector('.gvideo') : null;
                if (!slideVideo) {
                    return false;
                }

                var videoID = slideVideo.id;
                if (videoPlayers && videoPlayers.hasOwnProperty(videoID)) {
                    var player = videoPlayers[videoID];
                    if (hasClass(slideVideo, 'vimeo-video')) {
                        player.pause();
                    }
                    if (hasClass(slideVideo, 'youtube-video')) {
                        player.pauseVideo();
                    }
                    if (hasClass(slideVideo, 'jw-video')) {
                        player.pause(true);
                    }
                    if (hasClass(slideVideo, 'html5-video')) {
                        player.pause();
                    }
                }
            }
        }, {
            key: 'playSlideVideo',
            value: function playSlideVideo(slide) {
                if (utils.isNumber(slide)) {
                    slide = this.slidesContainer.querySelectorAll('.gslide')[slide];
                }
                var slideVideo = slide.querySelector('.gvideo');
                if (!slideVideo) {
                    return false;
                }
                var videoID = slideVideo.id;
                if (videoPlayers && videoPlayers.hasOwnProperty(videoID)) {
                    var player = videoPlayers[videoID];
                    if (hasClass(slideVideo, 'vimeo-video')) {
                        player.play();
                    }
                    if (hasClass(slideVideo, 'youtube-video')) {
                        player.playVideo();
                    }
                    if (hasClass(slideVideo, 'jw-video')) {
                        player.play();
                    }
                    if (hasClass(slideVideo, 'html5-video')) {
                        player.play();
                    }
                    setTimeout(function () {
                        removeClass(slideVideo, 'wait-autoplay');
                    }, 300);
                    return false;
                }
            }
        }, {
            key: 'setElements',
            value: function setElements(elements) {
                this.settings.elements = elements;
            }
        }, {
            key: 'getElements',
            value: function getElements() {
                var element = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;

                this.elements = [];

                if (!utils.isNil(this.settings.elements) && utils.isArray(this.settings.elements)) {
                    return this.settings.elements;
                }

                var nodes = false;
                if (element !== null) {
                    var gallery = element.getAttribute('data-gallery');
                    if (gallery && gallery !== '') {
                        nodes = document.querySelectorAll('[data-gallery="' + gallery + '"]');
                    }
                }
                if (nodes == false) {
                    nodes = document.querySelectorAll('.' + this.settings.selector);
                }
                nodes = Array.prototype.slice.call(nodes);
                return nodes;
            }
        }, {
            key: 'getActiveSlide',
            value: function getActiveSlide() {
                return this.slidesContainer.querySelectorAll('.gslide')[this.index];
            }
        }, {
            key: 'getActiveSlideIndex',
            value: function getActiveSlideIndex() {
                return this.index;
            }
        }, {
            key: 'getAnimationClasses',
            value: function getAnimationClasses() {
                var effects = [];
                for (var key in this.settings.cssEfects) {
                    if (this.settings.cssEfects.hasOwnProperty(key)) {
                        var effect = this.settings.cssEfects[key];
                        effects.push('g' + effect.in);
                        effects.push('g' + effect.out);
                    }
                }
                return effects.join(' ');
            }
        }, {
            key: 'build',
            value: function build() {
                var _this9 = this;

                if (this.built) {
                    return false;
                }

                var content, contentHolder, docFrag;

                var lightbox_html = createHTML(this.settings.lightboxHtml);
                document.body.appendChild(lightbox_html);

                var modal = document.getElementById('glightbox-body');
                this.modal = modal;
                var closeButton = modal.querySelector('.gclose');
                this.prevButton = modal.querySelector('.gprev');
                this.nextButton = modal.querySelector('.gnext');
                this.overlay = modal.querySelector('.goverlay');
                this.loader = modal.querySelector('.gloader');
                this.slidesContainer = document.getElementById('glightbox-slider');
                this.events = {};

                addClass(this.modal, 'glightbox-' + this.settings.skin);

                if (this.settings.closeButton && closeButton) {
                    this.events['close'] = addEvent('click', {
                        onElement: closeButton,
                        withCallback: function withCallback(e, target) {
                            e.preventDefault();
                            _this9.close();
                        }
                    });
                }

                if (this.nextButton) {
                    this.events['next'] = addEvent('click', {
                        onElement: this.nextButton,
                        withCallback: function withCallback(e, target) {
                            e.preventDefault();
                            _this9.nextSlide();
                        }
                    });
                }

                if (this.prevButton) {
                    this.events['prev'] = addEvent('click', {
                        onElement: this.prevButton,
                        withCallback: function withCallback(e, target) {
                            e.preventDefault();
                            _this9.prevSlide();
                        }
                    });
                }
                if (this.settings.closeOnOutsideClick) {
                    this.events['outClose'] = addEvent('click', {
                        onElement: modal,
                        withCallback: function withCallback(e, target) {
                            if (!getClosest(e.target, '.ginner-container')) {
                                if (!hasClass(e.target, 'gnext') && !hasClass(e.target, 'gprev')) {
                                    _this9.close();
                                }
                            }
                        }
                    });
                }
                each(this.elements, function () {
                    var slide = createHTML(_this9.settings.slideHtml);
                    _this9.slidesContainer.appendChild(slide);
                });
                if (isTouch) {
                    addClass(html, 'glightbox-touch');
                }

                this.built = true;
            }
        }, {
            key: 'close',
            value: function close() {
                var _this10 = this;

                if (this.closing) {
                    return false;
                }
                this.closing = true;
                this.stopSlideVideo(this.activeSlide);
                addClass(this.modal, 'glightbox-closing');
                animateElement(this.overlay, this.settings.openEffect == 'none' ? 'none' : this.settings.cssEfects.fade.out);
                animateElement(this.activeSlide, this.settings.closeEffect, function () {
                    _this10.activeSlide = null;
                    _this10.prevActiveSlideIndex = null;
                    _this10.prevActiveSlide = null;
                    _this10.built = false;

                    if (_this10.events) {
                        for (var key in _this10.events) {
                            if (_this10.events.hasOwnProperty(key)) {
                                _this10.events[key].destroy();
                            }
                        }
                    }

                    removeClass(body, 'glightbox-open');
                    removeClass(html, 'glightbox-open');
                    removeClass(body, 'touching');
                    removeClass(body, 'gdesc-open');
                    body.style.width = '';
                    _this10.modal.parentNode.removeChild(_this10.modal);
                    if (utils.isFunction(_this10.settings.onClose)) {
                        _this10.settings.onClose();
                    }
                    _this10.closing = null;
                });
            }
        }, {
            key: 'destroy',
            value: function destroy() {
                this.close();
                this.baseEvents.destroy();
            }
        }]);

        return GlightboxInit;
    }();

    module.exports = function () {
        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

        var instance = new GlightboxInit(options);
        instance.init();

        return instance;
    };
});

/* File */

// VanillaJS Part

// Explicit function

function meowq(query, parent = null) {
    if (null === parent) return document.querySelector(query);else return parent.querySelector(query);
}

function meowqa(query, parent = null) {
    if (null === parent) return document.querySelectorAll(query);else return parent.querySelectorAll(query);
}

function meowRand(max) {
    return Math.floor(Math.random() * Math.floor(max));
}

function JSON_to_QueryString(json) {
    var data = json;
    var result = '';
    for (key in data) {
        result += key + '=' + encodeURI(data[key]) + '&';
    }
    result = result.slice(0, result.length - 1);
    return result;
}

// Popup
function meow_caster_popupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = width / 2 - w / 2 + dualScreenLeft;
    var top = height / 2 - h / 2 + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes,toolbar=no, location=no, directories=no, status=no, menubar=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}

function meow_caster_popupActive() {

    // Add Popup open on link if no JS it's open it in a default target mode
    [].forEach.call(document.getElementsByClassName('mcss-popup'), function (el) {
        el.target = 'popup';
        el.addEventListener('click', function (e) {
            e.preventDefault();
            meow_caster_popupCenter(this.href, this.title, 600, 600);
            return false;
        });
    });
}

// Filter
function meow_caster_filter_text(el) {
    var key_up_timeout;
    el.addEventListener('keyup', function (ev) {
        var search = this.value.toLowerCase();
        var target_container = meowq(this.getAttribute('data-meow-target-container')),
            target_el = this.getAttribute('data-meow-target');

        clearTimeout(key_up_timeout);
        key_up_timeout = setTimeout(function () {
            if (!target_container.classList.contains('mcss-content-filter-search')) target_container.classList.add('mcss-content-filter-search');

            // reset
            all_items = meowqa(target_el, target_container);
            all_items.forEach(function (elem) {
                elem.setAttribute('data-search-match', 'no');
            });

            if (search !== '' && search !== undefined && search !== null) {
                //matching
                match = meowqa(target_el + '[data-name*="' + search + '"]', target_container);
                match.forEach(function (elem) {
                    elem.setAttribute('data-search-match', 'yes');
                });
            } else {
                target_container.classList.remove('mcss-content-filter-search');
            }
        }, 500);
    });
}

// Parser
function meow_caster_youtube_video_parser(url) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    return match && match[7].length == 11 ? match[7] : false;
}

function meow_caster_youtube_playlist_parser(url) {
    var reg = new RegExp("[&?]list=([^&|\\s]*)", "i");
    var match = reg.exec(url);
    if (match === null) {
        return false;
    } else {
        return match[1];
    }
}

// Meow Counter
function meow_caster_counter_update(elem, query) {
    var nbElem = query.length,
        nbDisplay = meowq('.nb', elem),
        singularDisplay = meowq('.singular', elem),
        pluralDisplay = meowq('.plural', elem);

    if (singularDisplay !== null) {
        if (nbElem > 1) {
            singularDisplay.style.display = 'none';
            pluralDisplay.style.display = 'inline';
        } else {
            pluralDisplay.style.display = 'none';
            singularDisplay.style.display = 'inline';
        }
    }
    nbDisplay.innerHTML = nbElem;
}

function meow_caster_video_gallery_list() {
    var container = document.getElementById('mcss-vgl-container-list');

    var editableList = Sortable.create(container, {
        animation: 150,
        filter: '.js-remove',
        onFilter: function (evt) {
            var el = editableList.closest(evt.item); // get dragged item
            el && el.parentNode.removeChild(el);
        }
    });
}

// Form gallery video
function meow_caster_vgl_form() {
    var select_type = document.getElementById("mcss-vgl-form-selType"),
        select_post = document.getElementById("mcss-vgl-form-selPost"),
        url = document.getElementById('mcss-vgl-form-url'),
        btn_validator = document.querySelectorAll('.mcss-vgl-form-validator'),
        col_selector = document.getElementById('mcss-vgl-form-col');

    for (var i = 0, len = btn_validator.length; i < len; i++) {
        btn_validator[i].addEventListener('click', function (evt) {
            evt.preventDefault();
            meow_caster_vgl_add_url(this);
        });
    }

    col_selector.addEventListener('change', function (ev) {
        var container = document.getElementById('mcss-vgl-container-list');
        container.setAttribute('data-col', this.value);
    });
}

function meow_caster_vgl_yt_oembed(data) {

    var response = JSON.parse(data.target.response);
    var elem = document.getElementById(response.tmpId);

    input = elem.querySelector('input');
    title = elem.querySelector('p');
    img = elem.getElementsByClassName('mcss-vgl-content-img');

    opt = JSON.parse(input.value);
    opt['title'] = response.data.title;
    title.innerHTML = response.data.title;
    title.classList.remove('mcss-vgl-empty-title');

    opt['thumbnail'] = response.data.thumbnail_url;

    if (img[0].src === 'https://i.ytimg.com/vi/false/mqdefault.jpg') {

        //console.log(response.data.thumbnail_url.replace('/..default\.jpg/gi', 'mqdefault.jpg'));
        img[0].src = response.data.thumbnail_url.replace(/..default\.jpg/gi, 'hqdefault.jpg');
    }

    input.value = JSON.stringify(opt);
}

function meow_caster_vgl_add_url(elem) {
    var url = document.getElementById('mcss-vgl-form-url').value,
        tmpId = meowRand(999);

    //if( elem.value === "vidurl"){

    preview_id = meow_caster_youtube_video_parser(url);
    preview_list = meow_caster_youtube_playlist_parser(url);

    opt = {
        action: "meow_caster_yt_oembed",
        'tmpId': tmpId,
        'id': preview_id,
        'list': preview_list
    };

    meow_request(opt, meow_caster_vgl_yt_oembed);

    inputvalue = {
        'tmpId': tmpId,
        'id': preview_id,
        'list': preview_list
    };
    meow_caster_vgl_add(inputvalue);

    document.getElementById('mcss-vgl-form-url').value = '';
}

function meow_caster_vgl_get_ids() {
    var container = document.getElementById('mcss-vgl-container-list'),
        listItems = meowqa('.mcss-vgl-content', container),
        listIds = [];
    listItems.forEach(function (a) {
        listIds.push(a.getAttribute('data-ytid'));
    });

    return listIds;
}

function meow_caster_vgl_add(inputvalue, preview_src = null) {

    var container = document.getElementById('mcss-vgl-container-list');

    //Perform generate for the flex table
    var itemgal = document.createElement('div'),
        itembtnremove = document.createElement('i'),
        itempreview = document.createElement('img'),
        iteminput = document.createElement('input'),
        itemtitle = document.createElement('p');

    itemgal.setAttribute('class', 'mcss-vgl-content');

    if (null === preview_src) {

        itemgal.id = inputvalue.tmpId;
        inputvalue.tmpId = undefined;
        itemgal.setAttribute('data-ytid', inputvalue.id);
        itempreview.setAttribute("src", 'https://i.ytimg.com/vi/' + inputvalue.id + '/mqdefault.jpg');
    } else {
        itemgal.setAttribute('data-ytid', inputvalue.id);
        itempreview.setAttribute("src", inputvalue.thumbnail);
    }

    itempreview.setAttribute('class', 'mcss-vgl-content-img');
    itembtnremove.setAttribute('class', 'js-remove');
    itembtnremove.innerHTML = "❌";
    itemgal.appendChild(itembtnremove);
    itemgal.appendChild(itempreview);

    iteminput.setAttribute('type', 'hidden');
    iteminput.setAttribute('name', '_meow-caster-video-gallery-list[items][]');
    iteminput.setAttribute('value', JSON.stringify(inputvalue));
    itemgal.appendChild(iteminput);

    if (undefined !== inputvalue.title) {
        itemtitle.setAttribute('class', 'mcss-vgl-content-title');
        itemtitle.innerHTML = inputvalue.title;
    } else {
        itemtitle.setAttribute('class', 'mcss-vgl-content-title mcss-vgl-empty-title');
    }
    itemgal.appendChild(itemtitle);

    container.appendChild(itemgal);
}

// Sync Buttons
function meow_caster_btn_sync(elems) {

    elems.forEach(function (el) {

        el.addEventListener('click', function (evt) {
            evt.preventDefault();
            meow_caster_btn_sync_evt(this);
        });
    });
}

function get_meow_caster_sync_opt() {
    var sync_opt_container = meowq('.mcjs-sync-opt'),
        sync_mod = meowq('[name=sync-opt]:checked', sync_opt_container);

    if (sync_mod.value === 'all' || sync_mod.value === 'default') {
        return sync_mod.value;
    } else {
        if (sync_mod.value !== 'part') {
            return false;
        }

        var sync_part = meowqa('.mcss-hide-by-radio input:checked', sync_opt_container);
        var return_value = '';

        sync_part.forEach(function (a) {
            return_value += a.value + '|';
        });

        if (return_value.length > 0) {
            return_value = return_value.substr(0, return_value.length - 1);
        }
        return return_value;
    }
}

function meow_caster_btn_sync_evt(elem) {

    var opt = {
        action: "meow_caster_sync",
        'btnId': elem.getAttribute('data-ytvid'),
        'sync': elem.getAttribute('data-sync'),
        'meowVID': elem.getAttribute('data-ytvid'),
        'meowGID': elem.getAttribute('data-ytpid'),
        'syncAttr': get_meow_caster_sync_opt()
    };
    console.log(opt.syncAttr);
    meow_request(opt, meow_caster_btn_sync_cb);
}

function meow_caster_btn_sync_cb(data) {
    var response = JSON.parse(data.target.response);

    if (response.status === true) {
        //location.reload();
    }
}

// Consent theme selector

function meow_caster_consent_theme_selector() {
    let selector_input = meowqa('.mcss-yts-consent-theme-input');

    selector_input.forEach(function (e) {
        e.addEventListener('change', function (evt) {
            evt.preventDefault();
            meow_caster_consent_theme_selector_evt(evt.target.value);
        });
    });
}
function meow_caster_consent_theme_selector_evt(evt) {
    let preview_consent = meowq('.mcss-player-consent-container');
    preview_consent.setAttribute('class', 'mcss-player-consent-container mcss-player-consent-theme-' + evt.target.value);
}

// load @ready
document.onreadystatechange = function (e) {
    // Ready
    if (document.readyState === "interactive") {

        if (document.getElementById('meow-caster-video-gallery-list') !== null) {
            meow_caster_video_gallery_list();
            meow_caster_vgl_form();
        }

        if (document.getElementsByClassName('mcss-popup')) {
            meow_caster_popupActive();
        }
        if (document.getElementsByClassName('mcss-btn-sync')) {
            meow_caster_btn_sync(meowqa('.mcss-btn-sync'));
        }
        if (meowqa('.mcjs-input-search').length > 0) {
            meowqa('.mcjs-input-search').forEach(function (a) {
                meow_caster_filter_text(a);
            });
        }
        if (meowqa('.mcss-main-config').length > 0) {
            meow_caster_consent_theme_selector();
        }
    }
};

var meowPrefixClass = 'mcss-',
    meowPrefixClassDot = '.mcss-';

function r(f) {
    /in/.test(document.readyState) ? setTimeout('r(' + f + ')', 9) : f();
}

r(function () {

    // Make responsive all element iframe or video by reframe or noframe
    if (document.querySelectorAll(meowPrefixClassDot + 'reframe').length > 0) {
        reframe(meowPrefixClassDot + 'reframe');
    }
    if (document.querySelectorAll(meowPrefixClassDot + 'noframe').length > 0) {
        noframe(meowPrefixClassDot + 'noframe');
    }
});

// jQuery Part
jQuery(document).ready(function ($) {

    // Tab A11y
    $(function () {
        var tabs = $(".mcss-tabs");

        // For each individual tab DIV, set class and aria-hidden attribute, and hide it
        $(tabs).find("> div").not(':first-child').attr({
            "class": "tabPanel",
            "aria-hidden": "true"
        }).hide();

        // Get the list of tab links
        var tabsList = tabs.find("ul:first").attr({
            "class": "tabsList"
        });

        // For each item in the tabs list...
        $(tabsList).find("li > a").each(function (a) {
            var tab = $(this);

            // Create a unique id using the tab link's href
            var tabId = "tab-" + tab.attr("href").slice(1);

            // Assign tab id and aria-selected attribute to the tab control, but do not remove the href
            tab.attr({
                "id": tabId,
                "aria-selected": "false"
            }).parent().attr("role", "presentation");

            // Assign aria attribute to the relevant tab panel
            $(tabs).find(".tabPanel").eq(a).attr("aria-labelledby", tabId);

            // Set the click event for each tab link
            tab.click(function (e) {
                var tabPanel;

                // Prevent default click event
                e.preventDefault();

                // Change state of previously selected tabList item
                $(tabsList).find("> li.current").removeClass("current").find("> a").attr("aria-selected", "false");

                // Hide previously selected tabPanel
                $(tabs).find(".tabPanel:visible").attr("aria-hidden", "true").hide();

                // Show newly selected tabPanel
                tabPanel = $(tabs).find(".tabPanel").eq(tab.parent().index());
                tabPanel.attr("aria-hidden", "false").show();

                // Set state of newly selected tab list item
                tab.attr("aria-selected", "true").parent().addClass("current");

                // Set focus to the first heading in the newly revealed tab content
                tabPanel.children("h2").attr("tabindex", -1).focus();
            });
        });

        // Set keydown events on tabList item for navigating tabs
        $(tabsList).delegate("a", "keydown", function (e) {
            var tab = $(this);
            switch (e.which) {
                case 37:
                case 38:
                    if (tab.parent().prev().length !== 0) {
                        tab.parent().prev().find("> a").click();
                    } else {
                        $(tabsList).find("li:last > a").click();
                    }
                    break;
                case 39:
                case 40:
                    if (tab.parent().next().length !== 0) {
                        tab.parent().next().find("> a").click();
                    } else {
                        $(tabsList).find("li:first > a").click();
                    }
                    break;
            }
        });

        // Show the first tabPanel
        $(tabs).find(".tabPanel:first").attr("aria-hidden", "false").show();

        // Set state for the first tabsList li
        $(tabsList).find("li:first").addClass("current").find(" > a").attr({
            "aria-selected": "true",
            "tabindex": "0"
        });
    });

    // WP Color picker
    if ($('.mcss-color-picker')) {}
    // Add Color Picker to all inputs that have 'color-field' class
    //$('.mcss-color-picker').wpColorPicker();


    // SVG fake player
    if ($('#mcss-live-player')) {

        var live_player = $('#mcss-live-player'),
            container = $('.mcss-player-container');

        live_player.addClass(container.data('classplayer'));

        $('.mcjs-live-player').change(function () {

            if ($(this).prop('checked')) {
                live_player.addClass($(this).data('target'));
            } else {
                live_player.removeClass($(this).data('target'));
            }
        });
    }
    if ($('#mjs-player')) {

        // call API iframe
        var mjs_tag = document.createElement('script');

        mjs_tag.src = "https://www.youtube.com/iframe_api";
        var mjs_firstScriptTag = document.getElementsByTagName('script')[0];
        mjs_firstScriptTag.parentNode.insertBefore(mjs_tag, mjs_firstScriptTag);

        var mjs_player;

        function mjs_url_to_id(url) {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = url.match(regExp);

            if (match && match[2].length === 11) {
                return match[2];
            } else {
                return 'error';
            }
        }

        function mjs_onChange(e) {
            e.preventDefault();

            if (mjs_player !== undefined) {
                mjs_player = null;
                $('#mjs-player').parent()[0].innerHTML = '<div id="mjs-player"></div>';
            }
            mjs_player = new YT.Player('mjs-player', mjs_get_param());
        }

        function mjs_get_param() {
            videoId = mjs_url_to_id($('#mjs-player-test-link')[0].value);
            autoplay = $('#field-ytp-autoplay').prop('checked') ? 1 : 0;
            modest = $('#field-ytp-modest').prop('checked') ? 1 : 0;
            control = $('#field-ytp-control').prop('checked') ? 2 : 0;
            annotations = $('#field-ytp-annotations').prop('checked') ? 1 : 3;
            info = $('#field-ytp-info').prop('checked') ? 1 : 0;
            caption = $('#field-ytp-caption').prop('checked') ? 1 : 0;
            related = $('#field-ytp-related').prop('checked') ? 1 : 0;
            playsinline = $('#field-ytp-playsinline').prop('checked') ? 1 : 0;
            fullscreen = $('#field-ytp-fullscreen').prop('checked') ? 1 : 0;
            loop = $('#field-ytp-loop').prop('checked') ? 1 : 0;

            return {
                videoId: videoId,
                height: '360',
                width: '640',
                playerVars: {
                    "autoplay": autoplay,
                    modestbranding: modest,
                    cc_load_policy: caption,
                    iv_load_policy: annotations,
                    showinfo: info,
                    controls: control,
                    rel: related,
                    fs: fullscreen,
                    loop: loop,
                    playsinline: playsinline
                }
            };
        }

        $('#mjs-player-test-launch').click(mjs_onChange);
    }

    if ($('.mcss-widgetform-step1')) {

        $('body').on('click', '.mcss-widgetform-step1 input[type=radio]', function () {

            var value = this.value;
            var parent_step = $(this).closest('.mcss-widgetform-step1');
            parent_step.removeClass('mcss-only-video').removeClass('mcss-only-gallery').removeClass('mcss-only-live').removeClass('mcss-only-channel');
            console.log(value);
            if (value === "player" || value === "playlist") {
                parent_step.addClass('mcss-only-video');
            } else if (value === "gallery") {
                parent_step.addClass('mcss-only-gallery');
            } else if (value === "live") {
                parent_step.addClass('mcss-only-live');
            } else if (value === "channel") {
                parent_step.addClass('mcss-only-channel');
            }
        });
    }

    if ($('.mcjs-trigger-show')) {

        $('.mcjs-trigger-show').each(function (e) {

            $(this.nextSibling).hide(0);
        });
        $('.mcjs-trigger-show').click(function (e) {
            e.preventDefault();
            $(this.nextSibling).toggle(300);
        });
    }
});
// Request

function meow_xhr(method) {
    var xhr = new XMLHttpRequest();
    if ("withCredentials" in xhr) {
        // XHR for Chrome/Firefox/Opera/Safari.
        xhr.open(method, ajaxurl, true);
        xhr.withCredentials = true;
    } else if (typeof XDomainRequest != "undefined") {
        // XDomainRequest for IE.
        xhr = new XDomainRequest();
        xhr.open(method, ajaxurl);
    } else {
        // CORS not supported.
        xhr = null;
    }
    if (xhr !== null && method === 'POST') {
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //xhr.setRequestHeader('Content-type', 'application/json');
    }
    return xhr;
}

function meow_request(opt, callback, loading_callback = null) {
    var oReq = meow_xhr('POST');
    if (!oReq) {
        return;
    }

    oReq.onload = callback;

    if (opt.tmpId !== 1 && opt.tmpId !== null && opt.tmpId !== 0) {

        oReq.tmpId = opt.tmpId;
    }

    oReq.send(JSON_to_QueryString(opt));

    if (loading_callback !== null) {
        loading_callback;
    }

    return oReq;
}
// common
r(function () {
    if (document.body.classList.contains('meow-caster_page_meow-caster-import-yt') || document.body.classList.contains('meow-caster_page_meow-caster-premium-import-yt')) {
        // For url
        meow_import_by_url();

        // For channel
        meow_import_videos_by_channel();
    }
});

function meow_caster_update_counter(type) {

    if (type == 'listing-videos') {
        var listing = meowq('#mcss-import-listing');
        // update counter
        meow_caster_counter_update(meowq('.mcss-import-listing-counter', listing), meowqa('.mcss-import-preview', listing));
        meow_caster_counter_update(meowq('.mcss-import-listing-counter-imported', listing), meowqa('.mcss-import-preview[data-import="yes"]', listing));
    } else if (type === 'listing-galleries') {
        var listing = meowq('#mcss-import-galleries-listing');
        // update counter
        meow_caster_counter_update(meowq('.mcss-import-galleries-listing-counter', listing), meowqa('.mcss-import-preview', listing));
        meow_caster_counter_update(meowq('.mcss-import-galleries-listing-counter-imported', listing), meowqa('.mcss-import-preview[data-import="yes"]', listing));
    }
}

function meow_caster_ajax_import(opt = null, callback = null, callback_loading = null) {
    if (opt === null) return false;

    optReq = {
        action: "meow_caster_yt_import",
        'tmpId': opt.tmpId,
        'list': JSON.stringify(opt.list)
    };

    meow_request(optReq, callback, callback_loading);
}

function meow_caster_ajax_import_callback(data) {
    //console.log(data);
    origin = document.querySelector('[data-ajax-tmpid="' + this.tmpId + '"]');

    origin.classList.remove('mcjs-ajax-requested');
    origin.classList.remove('mcss-btn-wait');

    if (data.target.status !== 200) {
        origin.classList.add('mcss-btn-error');
        return false;
    }
    origin.classList.add('mcss-btn-ok');

    container = origin.parentElement.parentElement;
    if (container.classList.contains('mcss-import-preview')) {
        container.classList.add('mcss-anim-exit-right');
        setTimeout(function () {
            container.setAttribute('data-import', 'yes');
            container.classList.remove('mcss-anim-exit-right');
            // update counter
            meow_caster_update_counter('listing-videos');
        }, 600);
    }
}

function meow_caster_evt_import(evt) {
    evt.preventDefault();

    var btn = evt.target;
    tmpId = meowRand(99);

    opt = {
        'tmpId': tmpId,
        'list': {
            0: {
                'type': btn.getAttribute('data-type'),
                'id': btn.getAttribute('data-id')
            }
        }
    };
    btn.setAttribute('disabled', 'disabled');
    btn.setAttribute('data-ajax-tmpid', tmpId);
    btn.classList.add('mcjs-ajax-requested');
    btn.classList.add('mcss-btn-wait');
    meow_caster_ajax_import(opt, meow_caster_ajax_import_callback, meow_caster_ajax_import_url_loading);
}

function meow_caster_ajax_import_videos_channel_callback(data) {
    if (false === meow_caster_ajax_import_callback(data)) {
        return false;
    }

    var response = JSON.parse(data.target.response),
        listing_area = meowq('#mcss-import-listing'),
        listing = listing_area.getElementsByClassName('mcss-import-listing-content')[0];

    listing.innerHTML = response.html;

    var btnImport = listing.getElementsByClassName('mcjs-btn-import');
    //console.log( btnImport );
    if (btnImport.length > 0) {
        Array.from(btnImport).forEach(function (element) {
            element.addEventListener('click', meow_caster_evt_import);
        });
    }

    var origin = document.querySelector('[data-ajax-tmpid="' + this.tmpId + '"]');

    setTimeout(function () {
        origin.classList.remove('mcss-btn-ok');
        origin.removeAttribute('disabled');
    }, 1000);

    meow_caster_update_counter('listing-videos');
}

function meow_caster_ajax_import_url_loading() {

    document.querySelectorAll('.mcjs-ajax-requested').forEach(function (a, b, c) {
        a.classList.remove('mcjs-ajax-loading');
        a.classList.remove('mcjs-ajax-requested');
    });
}

// preview for the import by URL
function meow_import_by_url() {
    // event listener
    var tabsImportURL = meowq('#mcjs-preview-url-import'),
        url_field = document.getElementById('mcss_import_url_url'),
        preview_area = tabsImportURL.getElementsByClassName('mcss-import-preview')[0],
        btn_import = preview_area.getElementsByTagName('button')[0],
        key_up_timeout = null;

    url_field.addEventListener('keyup', function (ev) {
        var url = this.value;
        clearTimeout(key_up_timeout);
        key_up_timeout = setTimeout(function () {

            preview_id = meow_caster_youtube_video_parser(url);
            preview_list = meow_caster_youtube_playlist_parser(url);

            if (preview_id === false && preview_list === false) {
                return true;
            }
            opt = {
                action: "meow_caster_yt_oembed",
                'tmpId': 1,
                'id': preview_id,
                'list': preview_list
            };

            meow_request(opt, meow_caster_import_url_oembed, meow_caster_import_url_loading);
        }, 500);
    });

    btn_import.addEventListener('click', meow_caster_evt_import);
}

function meow_caster_import_url_loading() {
    preview_area = document.getElementById('mcss-import-preview');
    container = preview_area.parentElement;
    container.classList.remove('mcss-import-url-ready');
    container.classList.add('mcss-import-url-loading');
}

function meow_caster_import_url_oembed(data) {

    var response = JSON.parse(data.target.response),
        rdata = response.data,
        preview_area = meowq('#mcjs-preview-url-import').querySelector('.mcss-import-preview'),
        container = preview_area.parentElement,
        btn_import = preview_area.getElementsByTagName('button')[0];

    container.classList.remove('mcss-import-url-loading');
    container.classList.add('mcss-import-url-ready');

    // Reset import btn

    btn_import.classList.remove('mcss-btn-ok');
    btn_import.classList.remove('mcss-btn-error');
    btn_import.classList.remove('mcss-btn-wait');
    btn_import.removeAttribute('disabled');

    //@TODO add error when URL wrong or for a playlist change to add all video import button

    if (rdata.list === "false") {
        preview_area.getElementsByClassName('playlist')[0].style.display = 'none';
        btn_import.setAttribute('data-id', rdata.id);
        btn_import.setAttribute('data-type', 'video');
    } else {
        preview_area.getElementsByClassName('playlist')[0].style.display = null;
        btn_import.setAttribute('data-id', rdata.list);
        btn_import.setAttribute('data-type', 'playlist');
    }
    if (response.imported === true) {
        btn_import.setAttribute('disabled', 'disabled');
        btn_import.classList.add('mcss-btn-ok');
    }
    preview_area.getElementsByTagName('img')[0].src = rdata.thumbnail_url;
    preview_area.getElementsByTagName('h4')[0].innerHTML = rdata.title;
    preview_area.getElementsByClassName('channel')[0].innerHTML = rdata.author_name;
}

// preview for the import by Channel
function meow_import_videos_by_channel() {

    var listing_area = meowq('#mcss-import-listing'),
        listing = listing_area.getElementsByClassName('mcss-import-listing-content')[0],
        btn_refresh = document.getElementsByClassName('mcss_import_refresh_list_video')[0],
        key_up_timeout = null,
        filter_imported = document.getElementById('mcss-import-listing-hide'),
        filter_search = document.getElementById('mcss-import-listing-search');

    //refresh action
    btn_refresh.addEventListener('click', function (evt) {
        evt.preventDefault();
        tmpId = meowRand(99);
        this.setAttribute('disabled', 'disabled');
        this.setAttribute('data-ajax-tmpid', tmpId);
        this.classList.add('mcjs-ajax-requested');
        opt = {
            action: "meow_caster_yt_listing_videos",
            'tmpId': tmpId
        };
        meow_request(opt, meow_caster_ajax_import_videos_channel_callback, meow_caster_ajax_import_url_loading);
    });

    //filter
    if (!filter_imported.checked && !listing.classList.contains('mcss-content-filter-imported')) {
        listing.classList.add('mcss-content-filter-imported');
    }

    filter_imported.addEventListener('change', function (ev) {

        if (filter_imported.checked) {
            if (listing.classList.contains('mcss-content-filter-imported')) {
                listing.classList.remove('mcss-content-filter-imported');
            }
        } else {
            if (!listing.classList.contains('mcss-content-filter-imported')) {
                listing.classList.add('mcss-content-filter-imported');
            }
        }
    });

    filter_search.addEventListener('keyup', function (ev) {
        var search = this.value.toLowerCase();
        clearTimeout(key_up_timeout);
        key_up_timeout = setTimeout(function () {
            if (!listing.classList.contains('mcss-content-filter-search')) listing.classList.add('mcss-content-filter-search');

            // reset
            all_items = meowqa('.mcss-import-preview', listing_area);
            all_items.forEach(function (elem) {
                elem.setAttribute('data-search-match', 'no');
            });

            if (search !== '' && search !== undefined && search !== null) {
                //matching
                match = meowqa('.mcss-import-preview[data-name*="' + search + '"]', listing_area);
                match.forEach(function (elem) {
                    elem.setAttribute('data-search-match', 'yes');
                });
                meow_caster_counter_update(meowq('.mcss-import-listing-counter', meowq('#mcss-import-listing')), match);
                meow_caster_counter_update(meowq('.mcss-import-listing-counter-imported', meowq('#mcss-import-listing')), meowqa('.mcss-import-preview[data-import="yes"][data-name*="' + search + '"]', meowq('#mcss-import-listing')));
            } else {
                listing.classList.remove('mcss-content-filter-search');

                meow_caster_counter_update(meowq('.mcss-import-listing-counter', meowq('#mcss-import-listing')), meowqa('.mcss-import-preview', meowq('#mcss-import-listing')));
                meow_caster_counter_update(meowq('.mcss-import-listing-counter-imported', meowq('#mcss-import-listing')), meowqa('.mcss-import-preview[data-import="yes"]', meowq('#mcss-import-listing')));
            }
        }, 500);
    });

    meow_caster_update_counter('listing-videos');

    var btnImport = meowqa('.mcjs-btn-import', listing);

    if (btnImport.length > 0) {
        Array.from(btnImport).forEach(function (element) {
            element.addEventListener('click', meow_caster_evt_import);
        });
    }
}

// preview Other?


function meow_caster_vtg_filter_switch(sender) {
    if (sender.classList.contains('mcss-vtg-link-disable')) {
        return false;
    }

    var target = meowq(sender.parentNode.getAttribute('data-target')),
        other_filter = meowq('.mcss-vtg-link-disable', sender.parentNode);

    if (target.classList.contains('mcss-vtg-filter-selected')) {
        target.classList.remove('mcss-vtg-filter-selected');
    } else {
        target.classList.add('mcss-vtg-filter-selected');
    }

    sender.classList.add('mcss-vtg-link-disable');
    other_filter.classList.remove('mcss-vtg-link-disable');
    return true;
}

function MeowCasterVTG(elem) {

    this.container = elem;

    this.videoContainer = meowq('.mcss-vtg-video', this.container);
    this.galleryContainer = meowq('.mcss-vtg-gallery', this.container);

    // initialyze
    this._init = function () {

        this._addEventListener();
    };

    // setup listener
    this._addEventListener = function () {

        this._ae_selection();
        this._ae_update_selection();
        this._ae_filter_selected();
    };

    // Event listener
    this._ae_selection = function () {
        var btnAdd = meowqa('.mcjs-vtg-add', this.container);

        btnAdd.forEach(function (a) {
            a.addEventListener('click', function (evt) {
                this.parentNode.parentNode.classList.add('mcss-vtg-item-selected');
                this.parentNode.parentNode.parentNode.parentNode.dispatchEvent(new Event('update-selection'));
            });
        });

        var btnRemove = meowqa('.mcjs-vtg-remove', this.container);

        btnRemove.forEach(function (a) {
            a.addEventListener('click', function (evt) {
                this.parentNode.parentNode.classList.remove('mcss-vtg-item-selected');
                this.parentNode.parentNode.parentNode.parentNode.dispatchEvent(new Event('update-selection'));
            });
        });
    };

    this._ae_update_selection = function () {
        [this.videoContainer, this.galleryContainer].forEach(function (a) {
            a.addEventListener('update-selection', function () {
                meow_caster_counter_update(meowq('.mcss-vtg-counter-selected', this), meowqa('.mcss-vtg-item-selected', this));
            });
        });
    };

    this._ae_filter_selected = function () {
        meowqa('.mcss-vtg-counter > a').forEach(function (elem) {

            elem.addEventListener('click', function (evt) {
                evt.preventDefault();
                meow_caster_vtg_filter_switch(this);
            });
        });
    };
}

r(function () {
    var vtg_container = meowq('.mcss-vtg-container');
    if (vtg_container) {
        var vtg = new MeowCasterVTG(vtg_container);
        vtg._init();
    }
});