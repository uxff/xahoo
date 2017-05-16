/**
 * Created by JS on 2015/9/1.
 */
define(function(){
    return {

        proxy : function( fn, proxy, thisObject){

            if ( arguments.length === 2 ) {
                // jQuery.proxy(context, name);
                if ( typeof proxy === "string" ) {
                    thisObject = fn;
                    fn = thisObject[ proxy ];
                    proxy = undefined;

                    /* ת�������
                     thisObject -> context
                     fn -> name
                     proxy -> undefined
                     */
                }
                // jQuery.proxy(name, context);
                else if ( proxy && typeof proxy !== 'function' ) {
                    thisObject = proxy;
                    proxy = undefined;
                }
            }
            if ( !proxy && fn ) {
                /* ʹ�� proxy ��֤ ����ִ��ʱ, context Ϊָ��ֵ */
                proxy = function() {
                    return fn.apply( thisObject || this, arguments );
                };
            }
            // Set the guid of unique handler to the same of original handler, so it can be removed
            if ( fn ) {
                proxy.guid = fn.guid = fn.guid || proxy.guid;
            }
            // So proxy can be declared as an argument
            return proxy;

        },

        extend : function(dest, someObj, override){

            var k;

            if(override === false){

                for(k in someObj){

                    !dest.hasOwnProperty(k) && someObj.hasOwnProperty(k) && (dest[k] = someObj[k]);

                }

            }else{

                for(k in someObj){

                    someObj.hasOwnProperty(k) && (dest[k] = someObj[k]);
                }

            }

            return dest;

        },

        clone : function(obj){
            var str, newobj = obj.constructor === Array ? [] : {};
            if(typeof obj !== 'object'){
                return;
            } else if(window.JSON){
                str = JSON.stringify(obj), //ϵ�л�����
                    newobj = JSON.parse(str); //��ԭ
            } else {
                for(var i in obj){
                    newobj[i] = typeof obj[i] === 'object' ?
                        clone(obj[i]) : obj[i];
                }
            }
            return newobj;
        },

        loadHTML : function(src, callback){
            if (!window.XMLHttpRequest) {
                window.setTimeout(function() { callback(false); }, 0);
                return;
            }
            var done = false;
            var xhr = new window.XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && !done) {
                    done = true;
                    callback(!!(this.responseXML));
                }
            }
            xhr.onabort = xhr.onerror = function() {
                if (!done) {
                    done = true;
                    callback(false);
                }
            }
            try {
                xhr.open("GET", src);
                xhr.responseType = "document";
                xhr.send();
            } catch (e) {
                window.setTimeout(function() {
                    if (!done) {
                        done = true;
                        callback(false);
                    }
                }, 0);
            }
        },

        storage : {

            get : function(key){

                return localStorage.getItem(key);

            },

            set : function(key, val){

                localStorage.setItem(key, val);

            },

            remove : function(key){

                localStorage.removeItem(key);

            }

        }
    }
})
