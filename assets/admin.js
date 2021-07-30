import "./css/admin.scss"

import { DiffEditor } from '/Elements/DiffEditor.jsx'


customElements.define('diff-editor', DiffEditor, { extends: 'textarea' })
