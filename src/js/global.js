'use strict';

var $ = require('jquery');
var animsition = require('animsition');

var global = {
  init: function(){
    
  },

  ready: function(){
    this.pageTransitions();
  },
  
  resize:function(){
  },
  
  scroll: function(){
    this.mobileHeader();
  },

  pageTransitions: function () {
    $(".animsition").animsition({
      inClass: 'fade-in',
      outClass: 'fade-out',
      inDuration: 1500,
      outDuration: 800,
      linkElement: '.transition-link',
      // e.g. linkElement: 'a:not([target="_blank"]):not([href^="#"])'
      loading: true,
      loadingParentElement: 'body', //animsition wrapper element
      loadingClass: 'page-loading',
      loadingInner: '<div class="sc-loader"></div>', // e.g '<img src="loading.svg" />'
      timeout: true,
      timeoutCountdown: 50000,
      onLoadEvent: true,
      browser: [ 'animation-duration', '-webkit-animation-duration'],
      // "browser" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser.
      // The default setting is to disable the "animsition" in a browser that does not support "animation-duration".
      overlay : false,
      overlayClass : 'animsition-overlay-slide',
      overlayParentElement : 'body',
      transition: function(url){ window.location.href = url; }
    });
  },

  mobileHeader: function () {
    var scrollTop = $('body').scrollTop();
    if (scrollTop > 100) {
      $('header').addClass('solid');
    } else {
      $('header').removeClass('solid');
    }
  }

};
module.exports = global;