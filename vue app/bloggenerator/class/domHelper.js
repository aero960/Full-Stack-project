import _ from 'lodash'

export default class DomHelper {
    static FilterAttribute;

    constructor() {
        this.FilterAttribute = "filterHelper";
    }


    static smoothScroll(target, duration) {
        let targetPosition = target
        let startPosition = window.pageYOffset;
        let distance = targetPosition - startPosition;
        let startTime = null;

        let animate = (currentyTime) => {
            if (startTime === null) startTime = currentyTime;
            let timeElapsed = currentyTime - startTime;
            let run = ease(timeElapsed, startPosition, distance, duration);
            window.scrollTo(0, run);
            if (timeElapsed < duration) requestAnimationFrame(animate);
        };

        /*
        * ease function to smooth scroll*/
        let ease = (t, b, c, d) => {
            t /= d / 2;
            if (t < 1) return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        };

        requestAnimationFrame(animate);
    };


    static addDynamicImg(elContainer, imageUrl) {

        let image = new Image();
        image.src = imageUrl;
        return new Promise((res, rej) => {
            image.addEventListener('load', () => {


                setTimeout(() => {
                    elContainer.innerHTML = image.outerHTML;
                    res(true);
                }, 1000)

            });
            image.addEventListener('error', () => {

                elContainer.innerHTML = this.tagCreator('span', {text: "Unable to render image"}).outerHTML;
                rej(false);
            })
        })

    }


    static tagCreator(type, options) {
        let element = document.createElement(type);
        if (options.hasOwnProperty("text")) {
            const text = document.createTextNode(options["text"]);
            element.append(text);
        }

        delete options["text"];

        if (options.hasOwnProperty("elements")) {
            options.elements.forEach(value =>
                element.append(value))
        }
        delete options["elements"];
        for (let index in options) {
            const attribute = document.createAttribute(index);
            attribute.value = Array.isArray(options[index]) ? options[index].join(" ") : options[index];
            element.setAttribute(attribute.name, attribute.value)
        }

        return element;
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