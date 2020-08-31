var ComingSoon = function () {

    return {
        //main function to initiate the module
        init: function () {

            $.backstretch([
		        "/asset/img/bg/"+Math.floor((Math.random()*20)+1)+".png",
		        "/asset/img/bg/"+Math.floor((Math.random()*20)+1)+".png",
                "/asset/img/bg/"+Math.floor((Math.random()*20)+1)+".png",
                "/asset/img/bg/"+Math.floor((Math.random()*20)+1)+".png",
		        "/asset/img/bg/"+Math.floor((Math.random()*20)+1)+".png"
		        ], {
		          fade: 1000,
		          duration: 8000
		    });

            
        }

    };

}();