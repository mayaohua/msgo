var page = require('webpage').create();
var args = require('system').args;
console.log(args)
var url = args[0];
console.log(0);
page.open(url, function(status){
    console.log(123);
    if(status === "success"){
        var ua = page.evaluate(function(){
            console.log(document.body.innerText);
            return url
        })
        console.log(ua);
    }
    phantom.exit();
});