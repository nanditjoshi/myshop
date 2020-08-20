const galleryContainer = document.querySelector(".gallery-container"),
    galleryControlsContainer = document.querySelector(".gallery-controls"),
    galleryControls = ["previous", "next"],
    galleryItems = document.querySelectorAll(".gallery-item");
class Carousel {
    constructor(e, l, a) {
        this.carouselContainer = e, this.carouselControls = a, this.carouselArray = [...l]
    }
    setInitialState() {
        this.carouselArray[0].classList.add("gallery-item-first"), 
		this.carouselArray[1].classList.add("gallery-item-previous"), 
		this.carouselArray[2].classList.add("gallery-item-selected"), 
		this.carouselArray[3].classList.add("gallery-item-next"), 
		this.carouselArray[4].classList.add("gallery-item-last"), 
		document.querySelector(".gallery-nav").childNodes[0].className = "gallery-nav-item gallery-item-first", 
		document.querySelector(".gallery-nav").childNodes[1].className = "gallery-nav-item gallery-item-previous", 
		document.querySelector(".gallery-nav").childNodes[2].className = "gallery-nav-item gallery-item-selected", 
		document.querySelector(".gallery-nav").childNodes[3].className = "gallery-nav-item gallery-item-next", 
		document.querySelector(".gallery-nav").childNodes[4].className = "gallery-nav-item gallery-item-last"
    }
    setCurrentState(e, l, a, t, r, s) {
        l.forEach(l => {
            l.classList.remove("gallery-item-selected"), "gallery-controls-previous" == e.className ? l.classList.add("gallery-item-next") : l.classList.add("gallery-item-previous")
        }), a.forEach(l => {
            l.classList.remove("gallery-item-previous"), "gallery-controls-previous" == e.className ? l.classList.add("gallery-item-selected") : l.classList.add("gallery-item-first")
        }), t.forEach(l => {
            l.classList.remove("gallery-item-next"), "gallery-controls-previous" == e.className ? l.classList.add("gallery-item-last") : l.classList.add("gallery-item-selected")
        }), r.forEach(l => {
            l.classList.remove("gallery-item-first"), "gallery-controls-previous" == e.className ? l.classList.add("gallery-item-previous") : l.classList.add("gallery-item-last")
        }), s.forEach(l => {
            l.classList.remove("gallery-item-last"), "gallery-controls-previous" == e.className ? l.classList.add("gallery-item-first") : l.classList.add("gallery-item-next")
        })
    }
    setNav() {
        galleryContainer.appendChild(document.createElement("ul")).className = "gallery-nav", this.carouselArray.forEach(e => {
            galleryContainer.lastElementChild.appendChild(document.createElement("li"))
        })
    }
    setControls() {
        this.carouselControls.forEach(e => {
            galleryControlsContainer.appendChild(document.createElement("button")).className = `gallery-controls-${e}`
        }), galleryControlsContainer.childNodes[0] && (galleryControlsContainer.childNodes[0].innerHTML = this.carouselControls[0]), 
		galleryControlsContainer.childNodes[1] && (galleryControlsContainer.childNodes[1].innerHTML = this.carouselControls[1])
    }
    useControls() {
        [...galleryControlsContainer.childNodes].forEach(e => {
            e.addEventListener("click", () => {
                const l = e,
                    a = document.querySelectorAll(".gallery-item-selected"),
                    t = document.querySelectorAll(".gallery-item-previous"),
                    r = document.querySelectorAll(".gallery-item-next"),
                    s = document.querySelectorAll(".gallery-item-first"),
                    o = document.querySelectorAll(".gallery-item-last");
                this.setCurrentState(l, a, t, r, s, o)
            })
        })
    }
}
const exampleCarousel = new Carousel(galleryContainer, galleryItems, galleryControls);
exampleCarousel.setControls(), exampleCarousel.setNav(), exampleCarousel.setInitialState(), exampleCarousel.useControls(), $(".gallery-item").on("touchstart", function(e) {
    var l = e.originalEvent.touches[0].pageX;
    $(this).one("touchmove", function(e) {
        var a = e.originalEvent.touches[0].pageX;
        Math.floor(l - a) > 5 ? $(this).carousel("next") : Math.floor(l - a) < -5 && $(this).carousel("prev")
    }), $(".gallery-item").on("touchend", function() {
        $(this).off("touchmove")
    })
});