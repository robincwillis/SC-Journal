'use strict';

var $ = require('jquery');

var fajax =  {
  init: function(){
    this.start = (new Date()).getTime();
    var siteURL = "http://" + top.location.host.toString();
    var $internalLinks = $("a[href^='"+siteURL+"'], a[href^='/'], a[href^='./'], a[href^='../']");
    $internalLinks.on('click',this.loadInternalLink);
  },
  ready: function(){
    var after = (new Date()).getTime();
    var timeout = 0;
    var elapsed = after-this.start;

    if ( elapsed <= 150){
      timeout = 150-elapsed;
    }
    setTimeout(function(){
      $('body').addClass('loaded');
      setTimeout(function(){
        $('#page').addClass('fade-in').removeClass('fajax-fade-in');
      },350);
    }, timeout);  
  },
  loadInternalLink: function(e){
    e.preventDefault();
    var link = e.currentTarget.href;
      $('body').removeClass('loaded');
      setTimeout(function(){
        window.location = link;
      },200);
  }
}

module.exports = fajax;