import "./css/admin.scss"

import { DiffEditor } from '/Elements/DiffEditor.jsx'
import {ItemSorter} from "/Elements/admin/itemSorter";
import {Spotlight} from "/Elements/admin/Spotlight";

customElements.define('diff-editor', DiffEditor, { extends: 'textarea' })
customElements.define('item-sorter', ItemSorter)

