/////////////////////////////////////////////////////////////////////////////////////////////////////

function SoundVisualizer () {
    (function () {
        var root = this;  														// use global context rather than window object
        var waveform_array, micStream;		// raw waveform data from web audio api
        var WAVE_DATA = []; 													// normalized waveform data used in visualizations

        // main app/init stuff //////////////////////////////////////////////////////////////////////////
        var a = {};
        a.init = function() {
            // globals & state
            var s = {
                width: '200px',
                height: '200px',
                sliderVal: 50,												// depricated -- value of html5 slider
                canKick: true,												// rate limits auto kick detector
                vendors: ['-webkit-', '-moz-', '-o-', ''],
                protocol: window.location.protocol,
                drawInterval: 1000 / 24,										// 1000ms divided by max framerate
                then: Date.now(),											// last time a frame was drawn
                trigger: 'circle',											// default visualization
                hud: 1,														// is hud visible?
                active: null,												// active visualization (string)
                vizNum: 0,
                component : "#stop-button"
            };

            root.State = s;
            root.context = new (window.AudioContext || window.webkitAudioContext)();

            // append main svg element
            root.svg = d3.select(root.State.component).append("svg").attr('id', 'viz')
                .attr("onclick","stopRecordingProject()")
                .attr("class","sound-visualizer")
                .attr("width", root.State.width)
                .attr("height", root.State.height);

            a.bind();			// attach all the handlers
            a.loadSound();
        };
        a.bind = function() {
            // console.log("a.bind fired");
            var click = (root.Helper.isMobile()) ? 'touchstart' : 'click';//모바일인지 확인
            $('.icon-microphone').on(click, a.microphone);
        };
        a.loadSound = function() {
            if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $('.menu-controls').hide();
                a.loadSoundAJAX();
            }
            else {
                a.loadSoundHTML5();
            }

        };
        a.loadSoundAJAX = function() {
            audio = null;
            var request = new XMLHttpRequest();
            request.open("GET", "mp3/"+root.State.playlist[0], true);
            request.responseType = "arraybuffer";
            request.onload = function(event) {
                var data = event.target.response;
                a.audioBullshit(data);
            };
            request.send();
        };
        a.loadSoundHTML5 = function() {
            audio = new Audio();
            a.audioBullshit();
        };
        a.loadAudioFromURL = function(url) {
            // console.log("loadAudioFromURL");
            root.State.audioURL = url;
            if (root.State.audioURL) {
                // a.loadSoundHTML5(url);
                a.loadSoundHTML5();
                return;
            }
        };
        a.microphone = function() {
            // this will only work over an https connection (or running the app locally)
            // console.log('a.microphone fired');
            if (root.State.protocol.indexOf('https') == -1) {
                // console.log("WARNING:: Accessing the microphone is only available using https://");
            }
            navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

            if (!micStream) {
                if (navigator.getUserMedia) {
                    navigator.getUserMedia({audio: true, video: false}, function(stream) {
                        micStream = true;
                        // console.log(" --> audio being captured");
                        root.context = new (window.AudioContext || window.webkitAudioContext)();
                        root.source = root.context.createMediaStreamSource(stream);
                        root.analyser = root.context.createAnalyser();
                        root.source.connect(root.analyser);
                        // console.log(micStream);
                        // audio.pause();


                    }, h.microphoneError);
                } else {
                    // fallback.
                }
            }
            else {
                source.disconnect();
                micStream = false;
            }
        };
        a.audioBullshit = function (data) {
            // uses web audio api to expose waveform data
            // console.log("a.audioBullshit fired");
            root.analyser = root.context.createAnalyser();
            //analyser.smoothingTimeConstant = .4; // .8 default
            if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                root.source = root.context.createBufferSource();
                root.source.buffer = root.context.createBuffer(data, false);
                root.source.loop = true;
                root.source.noteOn(0);
            }
            else {
                // https://developer.mozilla.org/en-US/docs/Web/API/AudioContext.createScriptProcessor
                root.source = root.context.createMediaElementSource(audio);  // doesn't seem to be implemented in safari :(
                //root.source = context.createMediaStreamSource()
                //root.source = context.createScriptProcessor(4096, 1, 1);
            }
            root.source.connect(root.analyser);
            root.analyser.connect(root.context.destination);
            a.frameLooper();
        };
        a.frameLooper = function(){
            // console.log("in the looper");
            //console.log("a.frameLooper fired");

            // recursive function used to update audio waveform data and redraw visualization
            window.requestAnimationFrame = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
            window.requestAnimationFrame(a.frameLooper);
            now = Date.now();
            delta = now - root.State.then;
            // if (audio){
            //     $('#progressBar').attr('style','width: '+(audio.currentTime/audio.duration)*100+"%");
            // }
            // some framerate limiting logic -- http://codetheory.in/controlling-the-frame-rate-with-requestanimationframe/
            if (delta > root.State.drawInterval) {
                root.State.then = now - (delta % root.State.drawInterval);
                // update waveform data
                if (h.detectEnvironment() != 'chrome-extension') {
                    // console.log("here");
                    waveform_array = new Uint8Array(root.analyser.frequencyBinCount);
                    root.analyser.getByteFrequencyData(waveform_array);
                    //analyser.getByteTimeDomainData(waveform_array);
                }

                // draw thumbnails
                // r.circle_thumb();
                root.State.vizNum = 0;
                r.circle();
            }
        };
        root.App = a;

        // manipulating/normalizing waveform data ///////////////////////////////////////////////////////
        var c = {};
        c.bins_select = function(binsize) {
            var copy = [];
            //binsize 가 100 이고 i % 100 이기 때문에 1개만 표시됨.
            //표기되는 원의 갯수를 늘리고 싶을 때 수정
            for (var i = 0 ; i < 51; i++) {
                if ( i % binsize == 0 ){
                    copy.push(waveform_array[i]);
                }
            }
            return copy;
        };
        //원이 퍼져 나가는 평균에 맞춰서 디스플레이
        c.bins_avg = function(binsize) {
            var binsize = binsize || 100;
            var copy = [];
            var temp = 0;
            for (var i = 0; i < waveform_array.length; i++) {
                temp += waveform_array[i];
                if (i%binsize==0) {
                    copy.push(temp/binsize);
                    temp = 0;
                }
            }
            //console.log(copy);
            return copy;
        };
        root.Compute = c;

        // rendering svg based on normalized waveform data //////////////////////////////////////////////
        var r = {};
        r.circle = function() {
            if (root.State.active != 'circle') {
                root.State.active = 'circle';
                $('body > svg').empty();
            }
            WAVE_DATA = c.bins_select(50);
            var x = d3.scale.linear()
                .domain([0, 270]) //감도 조정 부분, 두번째 부분 값이 크면 감도가 둔해지며 숫자가 작을수록 감도가 세짐
                .range([25, 70]); // 원의 크기.
            var slideScale = d3.scale.linear()
                .domain([0, 100])
                .range([0, 2]);
            root.bars = root.svg.selectAll("circle")
                .data(WAVE_DATA, function(d) { return d; });
            root.bars.enter().append("circle")
                .attr('transform', "scale("+slideScale(root.State.sliderVal)+")")
                .attr("cy", function(d, i) { return '50%'; })
                .attr("cx", function(d, i) { return '50%'; })
                .attr("r", function(d) { return x(d) + ""; });
            root.bars.exit().remove();
        };
        root.Render = r;

        // helper methods ///////////////////////////////////////////////////////////////////////////////
        var h = {};
        h.microphoneError = function(e) {

        };
        h.getURLParameter = function(sParam) {
            //http://www.jquerybyexample.net/2012/06/get-url-parameters-using-jquery.html
            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) {
                    return sParameterName[1];
                }
            }
        };
        h.isMobile = function() {
            // returns true if user agent is a mobile device
            return (/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent);
        };
        h.detectEnvironment = function() {
            // console.log("detectEnvironment fired");
            if (window.location.protocol.search('chrome-extension') >= 0)
                return 'chrome-extension';
            if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0)
                return 'safari';
            //  https://stackoverflow.com/questions/9847580/how-to-detect-safari-chrome-ie-firefox-and-opera-browser
            if (!!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0)
                return 'opera';
            if (typeof InstallTrigger !== 'undefined')
                return 'firefox';
            return 'unknown';
        };
        root.Helper = h;

    }).call(this);
}


