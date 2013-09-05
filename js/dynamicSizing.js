/*
  dynamicSizing.js
*/




$(document).ready(function(){

  var config = {
                maxWindow:1400,
                maxPercent:100,
                minWindow:500,
                minPercent:80,
                numberOfSteps:4
                };

  var object = new DocumentScaler(config);

  $(window).resize(function(){
      object.windowResized();
  });

  object.windowResized();

  window.setTimeout(function(){object.windowResized()},600);
});

function DocumentScaler(param){

    //private variables

    var maxWindow   = 1200;
    var maxPercent  = 100;
    var minWindow   = 500;
    var minPercent  = 50;
    var numberOfSteps = 2;

    var stepPercent;
    var stepPixels;
    var lastWidth;

    //constructor
    function construct(self){
      self.setMaxWindow(param.maxWindow);
      self.setMinWindow(param.minWindow);
      self.setMaxPercent(param.maxPercent);
      self.setMinPercent(param.minPercent);
      self.setNumberOfSteps(param.numberOfSteps);

      self.calculateStepPercent();
      self.calculateStepPixels();
    }

    //public methods


    this.windowResized = function(){

      var currentWidth = $(window).width();

      if(currentWidth >= maxWindow){
        // over large
        this.changeFontScale(100);
        this.changeCentralScale('60%');
        this.enlargeHeader();
      }else if(currentWidth <= minWindow){
        // over small
        this.changeFontScale(80);
        this.changeCentralScale('95%');
      }else if(currentWidth != lastWidth){
        // normal
        var percent = (Math.ceil( (currentWidth - minWindow) / stepPixels) * stepPercent) + minPercent;
        this.changeFontScale(100);
        this.changeCentralScale('80%');
        this.enlargeHeader();
      }

      if($('.header').height() > 70){
        this.shrinkHeader();
      }else{
        this.enlargeHeader();
      }

      return;
    }

    this.shrinkHeader = function(){
      $('.banner').css('float','none');
      $('.banner').css('display','block');
      $('.banner').css('font-size','150%');
      $('.header').css('text-align','center');
    }

    this.enlargeHeader = function(){
      $('.banner').css('float','right');
      $('.banner').css('display','inline-block');
      $('.banner').css('font-size','200%');
      $('.header').css('text-align','left');
    }
    this.changeCentralScale = function(percent){
      $('.center.column').css('width',percent);
    }

    this.changeFontScale = function(percent){
      if(document.body.style.fontSize){
        if(document.body.style.fontSize == percent + '%'){
          //same as before
        }else{
          document.body.style.fontSize = percent + '%';
        }
      }else{
        // not set
        document.body.style.fontSize = percent + '%';
      }
      lastWidth = $(window).width();
      return;
    }


    this.calculateNumberOfSteps = function(){
      numberOfSteps =
          Math.ceil( (maxPercent - minPercent) / stepPercent );
    }
    this.calculateStepPixels = function(){
      stepPixels =
          (maxWindow - minWindow) / (numberOfSteps - 1);
    }
    this.calculateStepPercent = function(){
      stepPercent = (maxPercent - minPercent) / (numberOfSteps -1);
    }

    this.setMaxWindow = function(newMaxWindow){
      maxWindow = newMaxWindow;
    }
    this.getMaxWindow = function(){
      return maxWindow;
    }

    this.setMaxPercent = function(newMaxPercent){
      maxPercent = newMaxPercent;
    }
    this.getMaxPercent = function(){
      return maxPercent;
    }

    this.setMinWindow = function(newMinWindow){
      minWindow = newMinWindow;
    }
    this.getMinWindow = function(){
      return minWindow;
    }

    this.setMinPercent = function(newMinPercent){
      minPercent = newMinPercent;
    }
    this.getMinPercent = function(){
      return minPercent;
    }

    this.setStepPercent = function(newStepPercent){
      stepPercent = newStepPercent;
    }
    this.getStepPercent = function(){
      return stepPercent;
    }

    this.setNumberOfSteps = function(newNumberOfSteps){
      numberOfSteps = newNumberOfSteps;
    }
    this.getNumberOfSteps = function(){
      return numberOfSteps;
    }

    this.log = function(){

      console.log('maxWindow - '    + maxWindow     + '\n' +
                  'maxPercent - '   + maxPercent    + '\n' +
                  'minWindow - '    + minWindow     + '\n' +
                  'minPercent - '   + minPercent    + '\n' +
                  'stepPercent - '  + stepPercent   + '\n' +
                  'numberOfSteps - '+ numberOfSteps + '\n' +
                  'stepPixels - '   + stepPixels5
                  );

    }

    //calls constructor once on object instantiation
    construct(this);

}
DocumentScaler.prototype.constructor = null;

