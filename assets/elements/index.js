import { Alert, FloatingAlert } from './Alert.js'
import { TimeAgo } from './TimeAgo.js'
import { InputChoices, SelectChoices } from './Choices.js'
import { Dropdown } from '/elements/Dropdown.js'
import { MarkdownEditor } from './editor/index.js'
import {Switch} from "/elements/Switch";

customElements.define('time-ago', TimeAgo)
customElements.define('alert-message', Alert)
customElements.define('alert-floating', FloatingAlert)
customElements.define('drop-down', Dropdown)
customElements.define('input-switch', Switch , { extends: 'input' })
customElements.define('input-choices', InputChoices, { extends: 'input' })
customElements.define('select-choices', SelectChoices, { extends: 'select' })
customElements.define('markdown-editor', MarkdownEditor, { extends: 'textarea' })
