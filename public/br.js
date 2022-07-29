var page = require('webpage').create();
const args = require('system').args;
var url = args[1];
page.open(url, function(status){
    setTimeout(function() {
        var ua =  page.evaluate(function(args){
            return getCode(args[2],args[3]);
        },args)
        console.log(ua);
        phantom.exit();
    },800);
    
});