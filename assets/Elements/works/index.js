import preactCustomElement from '/functions/preact.js'
import {WorksDelete} from "/Elements/works/WorksDelete";
import {WorkCreateMessage} from "/Elements/works/WorkCreateMessage";

preactCustomElement('workaction-delete', WorksDelete)
preactCustomElement('workaction-createmessage', WorkCreateMessage, ['topic', 'disabled'])