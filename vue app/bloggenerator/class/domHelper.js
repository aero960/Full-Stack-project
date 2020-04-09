import _ from 'lodash'

export default class DomHelper {
    static FilterAttribute;

    constructor() {
        this.FilterAttribute = "filterHelper";
    }

    static addHelperFilterElement(el, message) {
        try {
            if (_.isNull(el.parentElement.querySelector(`[${this.FilterAttribute}]`))) {
                let validHelper = document.createElement("div");
                validHelper.append(message);
                validHelper.setAttribute(this.FilterAttribute, true);
                el.after(validHelper);
            }
        } catch (error) {

        }
    }

    static deleteHelpers(el) {
        let listOfElementToRemove = el.parentElement.querySelectorAll(`[${this.FilterAttribute}]`)
        Array.from(listOfElementToRemove).map(index => {
            index.remove()
        })
    }

}