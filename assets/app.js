import '/css/app.scss'

import Turbolinks from 'turbolinks'

import {InputChoices, SelectChoices} from "/Elements/Choices";
import {Switch} from "/Elements/Switch";
import {TimeAgo} from "/Elements/TimeAgo";
import {DatePicker} from "/Elements/DatePicker";
import {Autogrow} from "/Elements/Autogrow";
import {MarkdownEditor} from "/Elements/editor";
import {NavTabs} from "@sb-elements/all";
import {Alert, FloatingAlert} from "/Elements/Alert";
import {Dropdown} from "/Elements/Dropdown";
import {AjaxDelete} from "/Elements/AjaxDelete";
import LoaderOverlay from "/Elements/LoaderOverlay";
import SpinningDots from '@grafikart/spinning-dots-element'
import preactCustomElement from '/functions/preact.js'
import {Comments} from "/Components/Comments";
import '/Elements/works/index'
import { $$, $ } from '/functions/dom.js'
import TomSelect from 'tom-select'
import './modules/highlight'
// Choices
$$('select[multiple]:not([is])').forEach(
    s =>
        new TomSelect(s, {
            plugins: {
                remove_button: {
                    title: 'Supprimer cet élément'
                }
            },
            maxItems: s.dataset.limit || null
        })
)

$$('form.js-preventMultiSubmit').forEach(form => {
    form.addEventListener('submit', () => {
        const button = form.querySelector('button[type="submit"]')
        if (button) {
            button.disabled = true
            button.innerText = 'Chargement...'
        }
    })
})
customElements.define('alert-message', Alert)
customElements.define('alert-floating', FloatingAlert)
customElements.define('nav-tabs', NavTabs)
customElements.define('time-ago', TimeAgo)
customElements.define('input-choices', InputChoices, { extends: 'input' })
customElements.define('select-choices', SelectChoices, { extends: 'select' })
customElements.define('input-switch',  Switch , { extends: 'input' })
customElements.define('date-picker', DatePicker, { extends: 'input' })
customElements.define('textarea-autogrow', Autogrow,{ extends: 'textarea' })
customElements.define('markdown-editor', MarkdownEditor, { extends: 'textarea' })
customElements.define('drop-down', Dropdown)
customElements.define('ajax-delete', AjaxDelete)
customElements.define('loader-overlay', LoaderOverlay)
customElements.define('spinning-dots', SpinningDots)
preactCustomElement('comments-area', Comments, ['target'])

Turbolinks.start()