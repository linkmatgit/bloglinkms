function debounce(callback, delay){
    let timer;
    return function(){
        let args = arguments;
        let context = this;
        clearTimeout(timer);
        timer = setTimeout(function(){
            callback.apply(context, args);
        }, delay)
    }
}
export class Autogrow extends HTMLTextAreaElement {

    constructor() {
        super()
        this.onFocus = this.onFocus.bind(this)
        this.autogrow =  this.autogrow.bind(this)
        this.onResize = debounce(this.onResize.bind(this), 300)
    }

    connectedCallback(){
        this.addEventListener('focus', this.onFocus)
        this.addEventListener('input', this.autogrow)


    }
    disconnectedCallback(){
        window.removeEventListener('resize', this.onResize)
    }
    onFocus () {
        this.autogrow()
        window.addEventListener('resize', this.onResize)
        this.removeEventListener('focus', this.onFocus)

    }
    autogrow() {
        this.style.height = 'auto'
        this.style.overflow = 'hidden'
        this.style.height = this.scrollHeight + 'px'
    }
    onResize(){
        this.autogrow()
    }
}
