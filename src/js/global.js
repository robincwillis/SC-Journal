'use strict';

var $ = require('jquery');
var animsition = require('animsition');
var slick = require('slick-carousel');
var lazysizes = require('lazysizes');

var global = {
  init: function(){
    
  },

  ready: function(){
    this.pageTransitions();
    this.slideshow();
    lazySizes.init();
    this.mailchimpSignup.init(this.mailchimpSignup);
    this.hideNewsletter();
    window.lazySizesConfig = {
      addClasses: true
    };
  },
  
  resize:function(){
  },
  
  scroll: function(){
    this.mobileHeader();
  },

  hideNewsletter : function () {
    if (localStorage.getItem("dismissedPopup")) {
      var dismissedDate = new Date (localStorage.getItem("dismissedPopup"));
      var todaysDate = new Date();

      if (dismissedDate.setHours(0,0,0,0) != todaysDate.setHours(0,0,0,0)) {
        $('.newsletter-popup').show();
      }
    } else {
      $('.newsletter-popup').show();
    }

    $('.newsletter-popup .close-popup').click(function() {
      $('.newsletter-popup').hide();
      localStorage.setItem( "dismissedPopup", new Date() );
      
    });
  },

  slideshow : function() {
    if (document.querySelector('.slideshow') !== null) {
      $('.slideshow').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: false
      });
    }
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
      loadingInner: '', // e.g '<img src="loading.svg" />'
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

  mailchimpSignup :{
    init : function() {
      var self = this;
      $('.newsletter-form').submit(function(e){
        self.subscribe(e, self);
      });
    },
    form : $('.newsletter-form'),

    subscribe : function(e, self){
      e.preventDefault();
      var form = self.form,
          td = $('.newsletter-form').attr('data-td'),
          link = td + '/assets/includes/mc_subscribe.php',
          request = $.ajax({
                      url: link,
                      type: 'POST',
                      data : $('.newsletter-form').serialize()
                    });
      request.done(self.handleResponse);
    },

    handleResponse : function(response){
      function outputMessage(msg){
        $('.newsletter-form').find('input[type=text]').val('');
        $('.newsletter-form').find('input[type=text]').blur();
        $('.newsletter-form').find('input[type=text]').attr('placeholder',msg);
      };
      var form = this.form;
      var resp = JSON.parse(response);          
      if (resp.title == 'Member Exists') {
        outputMessage('Thanks Times 2!');        
      } else if (resp.title == 'Invalid Resource' || resp.title == 'Internal Server Error') {
        outputMessage('Invalid Email');
      } else if (resp.status == 'subscribed') {
        outputMessage('Thanks');
      }else{
        outputMessage('Invalid Response');
      }
    }
  }, // End mailchimpSignup

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