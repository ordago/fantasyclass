// Toast management
import Toasted from 'vue-toasted';

export default {

    replaceSpecial(text) {
        text = text.replace("%XP%", "<i class='fas fa-fist-raised colored'></i>");
        text = text.replace("%GOLD%", "<i class='fas fa-coins colored'></i>");
        text = text.replace("%HP%", "<i class='fas fa-heart colored'></i>");
        text = text.replace("[XP]", "<i class='fas fa-fist-raised colored'></i>");
        text = text.replace("[GOLD]", "<i class='fas fa-coins colored'></i>");
        text = text.replace("[HP]", "<i class='fas fa-heart colored'></i>");
        return text;
    },
    getEmoji(grade, max) {

        let gradeCalc = grade * 5 / max;
        if (gradeCalc < 1.5) {
            return "fa-frown";
        } else if (gradeCalc < 2.5) {
            return "fa-frown-open";
        } else if (gradeCalc < 3.5) {
            return "fa-meh";
        } else if (gradeCalc < 4.5) {
            return "fa-smile";
        } else {
            return "fa-laugh-beam";
        }
    },

    getGradeClass(grade, max) {
        if(grade >= max / 2) {
            return 'is-success';
        }
        return 'is-danger';
    },

    getPassFail(grade, max) {
        if (grade < max/2) {
            return "fa-times"
        }
        return "fa-check";
    },

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


    /*
The MIT License (MIT)

Copyright (c) 2014 Chris Wilson

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

    /*

    Usage:
    audioNode = createAudioMeter(audioContext,clipLevel,averaging,clipLag);

    audioContext: the AudioContext you're using.
    clipLevel: the level (0 to 1) that you would consider "clipping".
       Defaults to 0.98.
    averaging: how "smoothed" you would like the meter to be over time.
       Should be between 0 and less than 1.  Defaults to 0.95.
    clipLag: how long you would like the "clipping" indicator to show
       after clipping has occured, in milliseconds.  Defaults to 750ms.

    Access the clipping through node.checkClipping(); use node.shutdown to get rid of it.
    */

    createAudioMeter: function (audioContext, clipLevel, averaging, clipLag) {
        var processor = audioContext.createScriptProcessor(512);
        processor.onaudioprocess = this.volumeAudioProcess;
        processor.clipping = false;
        processor.lastClip = 0;
        processor.volume = 0;
        processor.clipLevel = clipLevel || 0.98;
        processor.averaging = averaging || 0.95;
        processor.clipLag = clipLag || 750;

        // this will have no effect, since we don't copy the input to the output,
        // but works around a current Chrome bug.
        processor.connect(audioContext.destination);

        processor.checkClipping =
            function () {
                if (!this.clipping)
                    return false;
                if ((this.lastClip + this.clipLag) < window.performance.now())
                    this.clipping = false;
                return this.clipping;
            };

        processor.shutdown =
            function () {
                this.disconnect();
                this.onaudioprocess = null;
            };

        return processor;
    },

    volumeAudioProcess: function (event) {
        var buf = event.inputBuffer.getChannelData(0);
        var bufLength = buf.length;
        var sum = 0;
        var x;

        // Do a root-mean-square on the samples: sum up the squares...
        for (var i = 0; i < bufLength; i++) {
            x = buf[i];
            if (Math.abs(x) >= this.clipLevel) {
                this.clipping = true;
                this.lastClip = window.performance.now();
            }
            sum += x * x;
        }

        // ... then take the square root of the sum.
        var rms = Math.sqrt(sum / bufLength);

        // Now smooth this out with the averaging factor applied
        // to the previous sample - take the max here because we
        // want "fast attack, slow release."
        this.volume = Math.max(rms, this.volume * this.averaging);
    }


}
