// Toast management
import Toasted from 'vue-toasted';

export default {

    // 1 succes, 2, error 
    toast(vue, str, type = 0, duration = 5000, theme = "toasted-primary", ficon = "") {
            switch(type) {
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
                duration : duration,
                iconPack: 'fontawesome',
                icon : ficon,
        });
    },
    validEmail: function (email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    },

}