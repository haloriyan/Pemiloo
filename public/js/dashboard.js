let isMenuActive = false
const toggleMenu = e => {
    if (isMenuActive) {
        // select(".header").style.left = "0%"
        // select(".container").style.left = "5%"
        select(".header").classList.remove('active')
        select(".container").classList.remove('active')
        select(".LeftMenu").classList.remove('active')
        // select(".LeftMenu").style.left = "-100%"
    }else {
        // select(".header").style.left = "25%"
        // select(".container").style.left = "30%"
        select(".header").classList.add('active')
        select(".container").classList.add('active')
        select(".LeftMenu").classList.add('active')
        // select(".LeftMenu").style.left = "0%"
    }
    isMenuActive = !isMenuActive
}