/*!
 * B-JUI  v1.2 (http://b-jui.com)
 * Git@OSC (http://git.oschina.net/xknaan/B-JUI)
 * Copyright 2014 K'naan (xknaan@163.com).
 * Licensed under Apache (http://www.apache.org/licenses/LICENSE-2.0)
 */

/* ========================================================================
 * B-JUI: bjui-theme.js  v1.2
 * @author K'naan (xknaan@163.com)
 * http://git.oschina.net/xknaan/B-JUI/blob/master/BJUI/js/bjui-theme.js
 * ========================================================================
 * Copyright 2014 K'naan.
 * Licensed under Apache (http://www.apache.org/licenses/LICENSE-2.0)
 * ======================================================================== */

+function ($) {
    'use strict';
    
    // THEME GLOBAL ELEMENTS
    // ======================
    
    var $themeLink, $languageLis
    
    $(function() {
        var INIT_LANGUAGE = function() {
            $languageLis  = $('#bjui-language')
			if ($.cookie) {
                var languageName = $.cookie('think_language') || 'zh_cn'
                var $li = $languageLis.find('a.language_'+ languageName)
				$li.parent().addClass('active')
            }
        }
        
        INIT_LANGUAGE()
    })
    
    // THEME CLASS DEFINITION
    // ======================
    var Language = function(element, options) {
        this.$element = $(element)
        this.options  = options
    }
    
    Language.DEFAULTS = {
        language: 'zh_cn'
    }
    
    Language.prototype.init = function() {
		/* if (!$themeLink.length) return
        var themeHref = $themeLink.attr('href')
        
        themeHref = themeHref.substring(0, themeHref.lastIndexOf('/'))
        themeHref = themeHref.substring(0, themeHref.lastIndexOf('/'))
        themeHref += '/'+ this.options.theme +'/core.css'
        $themeLink.attr('href', themeHref)
        
        var $themeA = this.$element.closest('ul').prev()
        var classA  = $themeA.attr('class')
        
        classA      = classA.replace(/(theme[\s][a-z]*)/g, '')
        $themeA.removeClass().addClass(classA).addClass('theme').addClass(this.options.theme) */
        $languageLis.find('li').removeClass('active')
		
        this.$element.parent().addClass('active')
        this.cookie()
    }
    
    Language.prototype.setLanguage = function(themeName) {
        $languageLis.find('a.theme_'+ themeName).trigger('click')
    }
    
    Language.prototype.cookie = function() {
        var language = this.options.language
        console.log(language)
        if ($.cookie) $.cookie('think_language', language, { path: '/', expires: 30 });
    }
    
    // THEME PLUGIN DEFINITION
    // =======================
    
    function Plugin(option) {
        var args     = arguments
        var property = option
        
        return this.each(function () {
            var $this   = $(this)
            var options = $.extend({}, Language.DEFAULTS, $this.data(), typeof option == 'object' && option)
            var data    = $this.data('bjui.language')
            if (!data) $this.data('bjui.language', (data = new Language(this, options)))
				
            if (typeof property == 'string' && $.isFunction(data[property])) {
                [].shift.apply(args)
                if (!args) data[property]()
                else data[property].apply(data, args)
            } else {
                data.init()
            }
        })
    }
    
    // var old = $.fn.theme
    
    // $.fn.theme             = Plugin
    // $.fn.theme.Constructor = Language
    
    // THEME NO CONFLICT
    // =================
    
    // $.fn.theme.noConflict = function () {
        // $.fn.theme = old
        // return this
    // }
    
    // THEME DATA-API
    // ==============

    $(document).on('click', '[data-toggle="language"]', function(e) {
        Plugin.call($(this))
        window.location.reload();
        //e.preventDefault()
    })

}(jQuery);