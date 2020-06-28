// Toast management
import Toasted from 'vue-toasted';

export default {

    // 1 succes, 2, error 
    toast(vue, str, type = 0, duration = 5000, theme = "toasted-primary", ficon = "") {
        switch (type) {
            case 1:
                ficon = "check"
                theme = "toasted-primary"
                break;
            case 2:
                ficon = "times"
                theme = "bubble"
                break;
        }
        vue.$toasted.show(str, {
            theme: theme,
            position: "top-center",
            duration: duration,
            iconPack: 'fontawesome',
            icon: ficon,
        });
    },
    validEmail: function (email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    },

    styleText: function (original) {
        let text
        text = original.replace(/\*(.*?)\*/g, "<b>$1</b>");
        text = text.replace(/\_(.*?)\_/g, "<u>$1</u>");
        text = text.replace(/\^(.*?)\^/g, "<i>$1</i>");
        text = text.replace(/\[BR\]/g, "<br>");
        text = text.replace(/\[br\]/g, "<br>");
        return text
    },

    getYoutube(url) {
        var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        var match = url.match(regExp);

        if (match && match[2].length == 11) {
            return match[2];
        } else {
            return 'error';
        }
    },

    getURLRefactoring: function (url) {
        var regExp = /genial.ly/;
        var match = url.match(regExp);

        if (match) {
            return url.slice(0, url.lastIndexOf('/'));
        } else {
            return url;
        }
    },
}
