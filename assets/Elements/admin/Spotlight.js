import {h, render} from "preact";
import {SpotlightInput} from "/Elements/admin/SpotlightInput";


class Spotlight extends HTMLElement {



    connectedCallback() {
            return SpotlightInput
    }

    disconnectedCallback() {

    }
}