﻿/*
Name:       ImageFlow
Version:    1.3.0 (March 9 2010)
Author:     Finn Rudolph
Support:    http://finnrudolph.de/ImageFlow

License:    ImageFlow is licensed under a Creative Commons 
            Attribution-Noncommercial 3.0 Unported License 
            (http://creativecommons.org/licenses/by-nc/3.0/).

            You are free:
                + to Share - to copy, distribute and transmit the work
                + to Remix - to adapt the work

            Under the following conditions:
                + Attribution. You must attribute the work in the manner specified by the author or licensor 
                  (but not in any way that suggests that they endorse you or your use of the work). 
                + Noncommercial. You may not use this work for commercial purposes. 

            + For any reuse or distribution, you must make clear to others the license terms of this work.
            + Any of the above conditions can be waived if you get permission from the copyright holder.
            + Nothing in this license impairs or restricts the author's moral rights.

Credits:    This script is based on Michael L. Perrys Cover flow in Javascript [1].
            The reflections are generated server-sided by a slightly hacked version 
            of Richard Daveys easyreflections [2] written in PHP. The mouse wheel 
            support is an implementation of Adomas Paltanavicius JavaScript mouse 
            wheel code [3]. It also uses the domReadyEvent from Tanny O'Haley [4].

            [1] http://www.adventuresinsoftware.com/blog/?p=104#comment-1981
            [2] http://reflection.corephp.co.uk/v2.php
            [3] http://adomas.org/javascript-mouse-wheel/
            [4] http://tanny.ica.com/ICA/TKO/tkoblog.nsf/dx/domcontentloaded-for-browsers-part-v
*/

/* ImageFlow - compressed with http://dean.edwards.name/packer/ */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('v 4Z(){u.2v={3Q:50,2N:1.5a,2J:y,30:C,1a:y,3j:\'1E\',S:\'5u\',2h:1.0,J:4,33:\'\',2f:C,3a:0.49,36:1.0,2z:v(){B.3V=u.2i},1Y:y,1T:[10,8,6,4,2],2x:5t,2y:1d,3e:C,2M:C,3G:\'\',1N:0.5,31:y,3L:\'\',3u:0.6,2G:C,2X:\'e-5m\',1q:14,1y:y,34:5n,3k:y,3r:1,3D:C,3H:y,1g:4w};9 t=u;u.X=v(a){17(9 b 3T t.2v){u[b]=(a!==1t&&a[b]!==1t)?a[b]:t.2v[b]}9 c=B.R(t.S);7(c){c.A.1H=\'2g\';u.N=c;7(u.3N()){u.H=B.R(t.S+\'5j\');u.2j=B.R(t.S+\'4z\');u.1V=B.R(t.S+\'3X\');u.1B=B.R(t.S+\'4c\');u.1R=B.R(t.S+\'4f\');u.3x=B.R(t.S+\'4j\');u.3l=B.R(t.S+\'4s\');u.1L=B.R(t.S+\'5e\');u.1M=[];u.1w=0;u.E=0;u.1C=0;u.1D=0;u.2q=C;u.2s=C;u.T=y;9 d=u.N.3F;9 e=W.11(d/t.2N);B.R(t.S+\'2A\').A.3b=((e*0.5)-22)+\'M\';c.A.1c=e+\'M\';u.21()}}};u.3N=v(){9 a=t.D.U(\'12\',\'23\');9 b,2S,1l,15;9 c=t.N.F.1r;17(9 d=0;d<c;d++){b=t.N.F[d];7(b&&b.24==1&&b.29==\'2b\'){7(t.2M===C){2S=(t.31)?\'3\':\'2\';1l=t.33+b.1z(\'1l\',2);1l=t.3L+\'3W\'+2S+\'.45?5p=\'+1l+t.3G;b.2d(\'1l\',1l)}15=b.1O(C);a.Q(15)}}7(t.1a){9 e=t.D.U(\'12\',\'23\');9 f=t.D.U(\'12\',\'23\');c=a.F.1r;7(c<t.J){t.J=c}7(c>1){9 i;17(i=0;i<c;i++){b=a.F[i];7(i<t.J){15=b.1O(C);e.Q(15)}7(c-i<t.J+1){15=b.1O(C);f.Q(15)}}17(i=0;i<c;i++){b=a.F[i];15=b.1O(C);f.Q(15)}17(i=0;i<t.J;i++){b=e.F[i];15=b.1O(C);f.Q(15)}a=f}}7(t.1y){9 g=t.D.U(\'12\',\'1y\');a.Q(g)}9 h=t.D.U(\'p\',\'52\');9 j=B.3h(\' \');h.Q(j);9 k=t.D.U(\'12\',\'3v\');9 l=t.D.U(\'12\',\'4o\');k.Q(l);9 m=t.D.U(\'12\',\'4J\');9 n=t.D.U(\'12\',\'57\');9 o=t.D.U(\'12\',\'2G\');n.Q(o);7(t.2J){9 p=t.D.U(\'12\',\'4t\',\'35\');9 q=t.D.U(\'12\',\'41\',\'35\');n.Q(p);n.Q(q)}9 r=t.D.U(\'12\',\'46\');r.Q(m);r.Q(n);9 s=y;7(t.N.Q(a)&&t.N.Q(h)&&t.N.Q(k)&&t.N.Q(r)){c=t.N.F.1r;17(d=0;d<c;d++){b=t.N.F[d];7(b&&b.24==1&&b.29==\'2b\'){t.N.5q(b)}}s=C}V s};u.21=v(){9 p=t.2Y();7((p<1d||t.2s)&&t.3e){7(t.2s&&p==1d){t.2s=y;L.1n(t.21,1d)}G{L.1n(t.21,40)}}G{B.R(t.S+\'2A\').A.1Z=\'2H\';B.R(t.S+\'4L\').A.1Z=\'2H\';L.1n(t.D.3c,4W);t.2m();7(t.O>1){t.1e.X();t.I.X();t.K.X();t.2o.X();7(t.1y){t.P.X()}7(t.2G){t.1B.A.1H=\'2g\'}}}};u.2Y=v(){9 a=t.H.F.1r;9 i=0,20=0;9 b=Z;17(9 c=0;c<a;c++){b=t.H.F[c];7(b&&b.24==1&&b.29==\'2b\'){7(b.2I){20++}i++}}9 d=W.11((20/i)*1d);9 e=B.R(t.S+\'5g\');e.A.1u=d+\'%\';7(t.1a){i=i-(t.J*2);20=(d<1)?0:W.11((i/1d)*d)}9 f=B.R(t.S+\'2A\');9 g=B.3h(\'3v 23 \'+20+\'/\'+i);f.5i(g,f.4i);V d};u.2m=v(){u.Y=t.H.3F+t.H.3I;u.1A=W.11(t.Y/t.2N);u.1U=t.J*t.1g;u.1I=t.Y*0.5;u.1q=t.1q*0.5;u.1f=(t.Y-(W.11(t.1q)*2))*t.3u;u.2u=W.11(t.1A*t.3a);t.N.A.1c=t.1A+\'M\';t.H.A.1c=t.2u+\'M\';t.1V.A.1c=(t.1A-t.2u)+\'M\';t.2j.A.1u=t.Y+\'M\';t.2j.A.3b=W.11(t.Y*0.3q)+\'M\';t.1B.A.1u=t.1f+\'M\';t.1B.A.4m=W.11(t.Y*0.3q)+\'M\';t.1B.A.2R=W.11(t.1q+((t.Y-t.1f)/2))+\'M\';t.1R.A.3s=t.2X;t.1R.4u=v(){t.I.1p(u);V y};7(t.2J){t.3l.1k=v(){t.1e.19(1)};t.3x.1k=v(){t.1e.19(-1)}}9 a=(t.2M===C)?t.1N+1:1;9 b=t.H.F.1r;9 i=0;9 c=Z;17(9 d=0;d<b;d++){c=t.H.F[d];7(c!==Z&&c.24==1&&c.29==\'2b\'){u.1M[i]=d;c.2i=c.1z(\'4D\');c.4F=(-i*t.1g);c.i=i;7(t.2q){7(c.1z(\'1u\')!==Z&&c.1z(\'1c\')!==Z){c.w=c.1z(\'1u\');c.h=c.1z(\'1c\')*a}G{c.w=c.1u;c.h=c.1c}}7((c.w)>(c.h/(t.1N+1))){c.1j=t.2x;c.26=t.2x}G{c.1j=t.2y;c.26=t.2y}7(t.2f===y){c.A.4O=\'4S\';c.A.1Z=\'4U\'}c.A.3s=t.3j;i++}}u.O=t.1M.1r;7(t.2f===y){c=t.H.F[t.1M[0]];u.3J=c.w*t.O;c.A.55=(t.Y/2)+(c.w/2)+\'M\';t.H.A.1c=c.h+\'M\';t.1V.A.1c=(t.1A-c.h)+\'M\'}7(t.2q){t.2q=y;t.E=t.3r-1;7(t.E<0){t.E=0}7(t.1a){t.E=t.E+t.J}2U=(t.1a)?(t.O-(t.J))-1:t.O-1;7(t.E>2U){t.E=2U}7(t.3D===y){t.1K(-t.E*t.1g)}7(t.3H){t.1K(5v)}}7(t.O>1){t.1J(t.E)}t.1K(t.1w)};u.1K=v(x){u.1w=x;u.1o=t.O;17(9 a=0;a<t.O;a++){9 b=t.H.F[t.1M[a]];9 c=a*-t.1g;7(t.2f){7((c+t.1U)<t.1D||(c-t.1U)>t.1D){b.A.1H=\'3S\';b.A.1Z=\'2H\'}G{9 z=(W.4I(4p+x*x)+1d)*t.36;9 d=x/z*t.1I+t.1I;b.A.1Z=\'4r\';9 e=(b.h/b.w*b.1j)/z*t.1I;9 f=0;1G(e>t.1A){1x y:f=b.1j/z*t.1I;13;1E:e=t.1A;f=b.w*e/b.h;13}9 g=(t.2u-e)+((e/(t.1N+1))*t.1N);b.A.2Z=d-(b.1j/2)/z*t.1I+\'M\';7(f&&e){b.A.1c=e+\'M\';b.A.1u=f+\'M\';b.A.5s=g+\'M\'}b.A.1H=\'2g\';1G(x<0){1x C:u.1o++;13;1E:u.1o=t.1o-1;13}1G(b.i==t.E){1x y:b.1k=v(){t.1J(u.i)};13;1E:u.1o=t.1o+1;7(b.2i!==\'\'){b.1k=t.2z}13}b.A.1o=t.1o}}G{7((c+t.1U)<t.1D||(c-t.1U)>t.1D){b.A.1H=\'3S\'}G{b.A.1H=\'2g\';1G(b.i==t.E){1x y:b.1k=v(){t.1J(u.i)};13;1E:7(b.2i!==\'\'){b.1k=t.2z}13}}t.H.A.2R=(x-t.3J)+\'M\'}x+=t.1g}};u.1J=v(a){9 b,1v;7(t.1a){7(a+1===t.J){1v=t.O-t.J;b=-1v*t.1g;a=1v-1}7(a===(t.O-t.J)){1v=t.J-1;b=-1v*t.1g;a=1v+1}}9 x=-a*t.1g;u.1C=x;u.1D=x;u.E=a;9 c=t.H.F[a].1z(\'4v\');7(c===\'\'||t.30===y){c=\'&56;\'}t.2j.4e=c;7(t.I.T===y){7(t.1a){u.1b=((a-t.J)*t.1f)/(t.O-(t.J*2)-1)-t.I.2k}G{u.1b=(a*t.1f)/(t.O-1)-t.I.2k}t.1R.A.2R=(t.1b-t.1q)+\'M\'}7(t.1Y===C||t.2h!==t.2v.2h){t.D.27(t.H.F[a],t.1T[0]);t.H.F[a].1j=t.H.F[a].1j*t.2h;9 d=0;9 e=0;9 f=0;9 g=t.1T.1r;17(9 i=1;i<(t.J+1);i++){7((i+1)>g){d=t.1T[g-1]}G{d=t.1T[i]}e=a+i;f=a-i;7(e<t.O){t.D.27(t.H.F[e],d);t.H.F[e].1j=t.H.F[e].26}7(f>=0){t.D.27(t.H.F[f],d);t.H.F[f].1j=t.H.F[f].26}}}7(b){t.1K(b)}7(t.T===y){t.T=C;t.2E()}};u.2E=v(){1G(t.1C<t.1w-1||t.1C>t.1w+1){1x C:t.1K(t.1w+(t.1C-t.1w)/3);L.1n(t.2E,t.3Q);t.T=C;13;1E:t.T=y;13}};u.2l=v(a){7(t.1y){t.P.2c()}t.1J(a)};u.P={2n:1,X:v(){(t.3k)?t.P.1p():t.P.1h()},2c:v(){t.D.2L(t.N,\'3m\',t.P.2c);t.P.1h()},3o:v(){t.D.16(t.N,\'3m\',t.P.2c)},1p:v(){t.D.25(t.1L,\'1y 43\');t.1L.1k=v(){t.P.1h()};t.P.3t=L.47(t.P.2P,t.34);L.1n(t.P.3o,1d)},1h:v(){t.D.25(t.1L,\'1y 4b\');t.1L.1k=v(){t.P.1p()};L.4d(t.P.3t)},2P:v(){9 a=t.E+t.P.2n;9 b=y;7(a===t.O){t.P.2n=-1;b=C}7(a<0){t.P.2n=1;b=C}(b)?t.P.2P():t.1J(a)}};u.1e={X:v(){7(L.1m){t.N.1m(\'4h\',t.1e.1W,y)}t.D.16(t.N,\'4k\',t.1e.1W)},1W:v(a){9 b=0;7(!a){a=L.1F}7(a.3z){b=a.3z/4q}G 7(a.3B){b=-a.3B/3}7(b){t.1e.19(b)}t.D.2p(a)},19:v(a){9 b=y;9 c=0;7(a>0){7(t.E>=1){c=t.E-1;b=C}}G{7(t.E<(t.O-1)){c=t.E+1;b=C}}7(b){t.2l(c)}}};u.I={1P:Z,2T:0,2e:0,2k:0,T:y,X:v(){t.D.16(t.N,\'4B\',t.I.3K);t.D.16(t.N,\'3M\',t.I.1h);t.D.16(B,\'3M\',t.I.1h);t.N.4H=v(){9 a=C;7(t.I.T){a=y}V a}},1p:v(o){t.I.1P=o;t.I.2T=t.I.2e-o.3I+t.1b},1h:v(){t.I.1P=Z;t.I.T=y},3K:v(e){9 a=0;7(!e){e=L.1F}7(e.2D){a=e.2D}G 7(e.3P){a=e.3P+B.2K.3d+B.4Q.3d}t.I.2e=a;7(t.I.1P!==Z){9 b=(t.I.2e-t.I.2T)+t.1q;7(b<(-t.1b)){b=-t.1b}7(b>(t.1f-t.1b)){b=t.1f-t.1b}9 c,E;7(t.1a){c=(b+t.1b)/(t.1f/(t.O-(t.J*2)-1));E=W.11(c)+t.J}G{c=(b+t.1b)/(t.1f/(t.O-1));E=W.11(c)}t.I.2k=b;t.I.1P.A.2Z=b+\'M\';7(t.E!==E){t.2l(E)}t.I.T=C}}};u.K={x:0,2B:0,2r:0,T:y,2F:C,X:v(){t.D.16(t.1V,\'4Y\',t.K.1p);t.D.16(B,\'51\',t.K.19);t.D.16(B,\'53\',t.K.1h)},3f:v(e){9 a=y;7(e.28){9 b=e.28[0].1C;7(b===t.1V||b===t.1R||b===t.1B){a=C}}V a},2C:v(e){9 x=0;7(e.28){x=e.28[0].2D}V x},1p:v(e){t.K.2B=t.K.2C(e);t.K.T=C;t.D.2p(e)},3w:v(){9 a=y;7(t.K.T){a=C}V a},19:v(e){7(t.K.3w&&t.K.3f(e)){9 a=(t.1a)?(t.O-(t.J*2)-1):(t.O-1);7(t.K.2F){t.K.2r=(a-t.E)*(t.Y/a);t.K.2F=y}9 b=-(t.K.2C(e)-t.K.2B-t.K.2r);7(b<0){b=0}7(b>t.Y){b=t.Y}t.K.x=b;9 c=W.11(b/(t.Y/a));c=a-c;7(t.E!==c){7(t.1a){c=c+t.J}t.2l(c)}t.D.2p(e)}},1h:v(){t.K.2r=t.K.x;t.K.T=y}};u.2o={X:v(){B.5d=v(a){t.2o.19(a)}},19:v(a){9 b=t.2o.1W(a);1G(b){1x 39:t.1e.19(-1);13;1x 37:t.1e.19(1);13}},1W:v(a){a=a||L.1F;V a.5h}};u.D={16:v(a,b,c){7(a.1m){a.1m(b,c,y)}G 7(a.3g){a["e"+b+c]=c;a[b+c]=v(){a["e"+b+c](L.1F)};a.3g("3y"+b,a[b+c])}},2L:v(a,b,c){7(a.32){a.32(b,c,y)}G 7(a.3A){7(a[b+c]===1t){5r(\'D.2L » 4G 3i 3C 1F 48 1t - 4K 4l 4M 42 3i 3C 4N 4n 1F?\')}a.3A(\'3y\'+b,a[b+c]);a[b+c]=Z;a[\'e\'+b+c]=Z}},27:v(a,b){7(t.1Y===C){a.A.1Y=b/10;a.A.4P=\'4a(1Y=\'+b*10+\')\'}},U:v(a,b,c){9 d=B.4R(a);d.2d(\'38\',t.S+\'4T\'+b);7(c!==1t){b+=\' \'+c}t.D.25(d,b);V d},25:v(a,b){7(a){a.2d(\'3Z\',b);a.2d(\'4V\',b)}},2p:v(e){7(e.3E){e.3E()}G{e.4X=y}V y},3c:v(){9 a=L.2t;7(1X L.2t!=\'v\'){L.2t=v(){t.2m()}}G{L.2t=v(){7(a){a()}t.2m()}}}}}9 1i={2Q:"1i",1S:{},1s:1,1Q:y,2O:Z,3n:v(a){7(!a.$$1s){a.$$1s=u.1s++;7(u.1Q){a()}u.1S[a.$$1s]=a}},58:v(a){7(a.$$1s){4x u.1S[a.$$1s]}},18:v(){7(u.1Q){V}u.1Q=C;17(9 i 3T u.1S){u.1S[i]()}},2w:v(){7(u.1Q){V}7(/5c|4y/i.3O(4g.5f)){7(/4A|2I/.3O(B.3p)){u.18()}G{1n(u.2Q+".2w()",1d)}}G 7(B.R("2V")){V C}7(1X u.2O==="v"){7(1X B.2W!==\'1t\'&&(B.2W(\'2K\')[0]!==Z||B.2K!==Z)){7(u.2O()){u.18()}G{1n(u.2Q+".2w()",4C)}}}V C},X:v(){7(B.1m){B.1m("5k",v(){1i.18()},y)}1n("1i.2w()",1d);v 18(){1i.18()}7(1X 16!=="1t"){16(L,"3R",18)}G 7(B.1m){B.1m("3R",18,y)}G 7(1X L.2a==="v"){9 a=L.2a;L.2a=v(){1i.18();a()}}G{L.2a=18}/*@4E@7(@5o||@3Y)B.44("<3U 38=2V 54 1l=\\"//:\\"><\\/3U>");9 b=B.R("2V");b.59=v(){7(u.3p=="2I"){1i.18()}};@5b@*/}};9 5l=v(a){1i.3n(a)};1i.X();',62,342,'|||||||if||var|||||||||||||||||||||this|function|||false||style|document|true|Helper|imageID|childNodes|else|imagesDiv|MouseDrag|imageFocusMax|Touch|window|px|ImageFlowDiv|max|Slideshow|appendChild|getElementById|ImageFlowID|busy|createDocumentElement|return|Math|init|imagesDivWidth|null||round|div|break||imageNode|addEvent|for|run|handle|circular|newSliderX|height|100|MouseWheel|scrollbarWidth|xStep|stop|domReadyEvent|pc|onclick|src|addEventListener|setTimeout|zIndex|start|sliderWidth|length|domReadyID|undefined|width|clonedImageID|current|case|slideshow|getAttribute|maxHeight|scrollbarDiv|target|memTarget|default|event|switch|visibility|size|glideTo|moveTo|buttonSlideshow|indexArray|reflectionP|cloneNode|object|bDone|sliderDiv|events|opacityArray|maxFocus|navigationDiv|get|typeof|opacity|display|completed|loadingProgress||images|nodeType|setClassName|pcMem|setOpacity|touches|nodeName|onload|IMG|interrupt|setAttribute|mouseX|imageScaling|visible|imageFocusM|url|captionDiv|newX|glideOnEvent|refresh|direction|Key|suppressBrowserDefault|firstRefresh|stopX|firstCheck|onresize|imagesDivHeight|defaults|schedule|percentLandscape|percentOther|onClick|_loading_txt|startX|getX|pageX|animate|first|slider|none|complete|buttons|body|removeEvent|reflections|aspectRatio|DOMContentLoadedCustom|slide|name|marginLeft|version|objectX|maxId|__ie_onload|getElementsByTagName|sliderCursor|loadingStatus|left|captions|reflectionPNG|removeEventListener|imagePath|slideshowSpeed|button|imagesM||id||imagesHeight|paddingTop|addResizeEvent|scrollLeft|preloadImages|isOnNavigationDiv|attachEvent|createTextNode|to|imageCursor|slideshowAutoplay|buttonPreviousDiv|click|add|addInterruptEvent|readyState|02|startID|cursor|action|scrollbarP|loading|isBusy|buttonNextDiv|on|wheelDelta|detachEvent|detail|detach|glideToStartID|preventDefault|offsetWidth|reflectionGET|startAnimation|offsetLeft|totalImagesWidth|drag|reflectPath|mouseup|createStructure|test|clientX|animationSpeed|load|hidden|in|script|location|reflect|_navigation|_win64|class||next|trying|pause|write|php|navigation|setInterval|is|67|alpha|play|_scrollbar|clearInterval|innerHTML|_slider|navigator|DOMMouseScroll|firstChild|_next|mousewheel|you|marginTop|unattached|loading_bar|10000|120|block|_previous|previous|onmousedown|alt|150|delete|WebKit|_caption|loaded|mousemove|250|longdesc|cc_on|xPosition|Pointer|onselectstart|sqrt|caption|perhaps|_loading|are|an|position|filter|documentElement|createElement|relative|_|inline|className|1000|returnValue|touchstart|ImageFlow||touchmove|loading_txt|touchend|defer|paddingLeft|nbsp|scrollbar|remove|onreadystatechange|964|end|KHTML|onkeydown|_slideshow|userAgent|_loading_bar|keyCode|replaceChild|_images|DOMContentLoaded|domReady|resize|1500|_win32|img|removeChild|alert|top|118|imageflow|5000'.split('|'),0,{}));

/* Create ImageFlow instances when the DOM structure has been loaded */
domReady(function()
{
	var instance0 = new ImageFlow();
	instance0.init({ ImageFlowID:'myImageFlow0',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});
	
		var instance1 = new ImageFlow();
	instance1.init({ ImageFlowID:'myImageFlow1',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});

	var instance2 = new ImageFlow();
	instance2.init({ ImageFlowID:'myImageFlow2',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});

	var instance3 = new ImageFlow();
	instance3.init({ ImageFlowID:'myImageFlow3',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});

	var instance4 = new ImageFlow();
	instance4.init({ ImageFlowID:'myImageFlow4',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});

	var instance5 = new ImageFlow();
	instance5.init({ ImageFlowID:'myImageFlow5',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});

	var instance6 = new ImageFlow();
	instance6.init({ ImageFlowID:'myImageFlow6',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});

	var instance7 = new ImageFlow();
	instance7.init({ ImageFlowID:'myImageFlow7',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});

	var instance8 = new ImageFlow();
	instance8.init({ ImageFlowID:'myImageFlow8',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});



	var instance9 = new ImageFlow();
	instance9.init({ ImageFlowID:'myImageFlow9',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});

	var instance10 = new ImageFlow();
	instance10.init({ ImageFlowID:'myImageFlow10',
		aspectRatio: 2.5,
		imageFocusMax: 1,
		reflectionP: 0.5,
		imagesHeight: 0.67,
                slider: false,
                captions: false,
		reflections: false,
		imageFocusM:2.0,
                onClick: function() { return hs.expand(this,
                                    { src: this.getAttribute('longdesc'), 
                                       outlineType: 'rounded-white', 
                                       fadeInOut: true } ); }
	});



});