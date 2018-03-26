function jsonp() {

    console.log("jsonp");

    $.ajax({
        // url: "http://jian-yin.com/index.php/pinyin?words=7456",
        url: "/index.php/welcome/api",
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
        url: "/index.php/welcome/api",
        dataType: "json",
        success: function(response) {
            console.log("success");
        },
        error: function(response) {
            console.log("error");
        }
    });
}
