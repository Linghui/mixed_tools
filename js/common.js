function jsonp() {

    console.log("jsonp");
    function mycll() {

    }

    $.ajax({
        // url: "http://jian-yin.com/index.php/pinyin?words=7456",
        url: "/index.php/main/api",
        jsonp: "callback",
        dataType: "jsonp",
        success: function(response) {
            console.log("success");
        },
        error: function(response) {
            console.log("error");
        }
    });
}

function json() {

    console.log("json");

    $.ajax({
        url: "/index.php/main/api",
        dataType: "json",
        success: function(response) {
            console.log("success");
        },
        error: function(response) {
            console.log("error");
        }
    });
}
