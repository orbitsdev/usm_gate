

gsap.registerPlugin(ScrollTrigger)
// gsap.fromTo(".parent-percentage .percentage", {
//     y:200,
//     opacity:0,

//     scrollTrigger:{
//         trigger: ".mytest",
//         start: "top center",
//         markers: true,
//         scrubs: 1,
//     }
// },{
// y:0,
// opacity:1,
// duration:2,
// ease: "back(1)"

// }

// )


let percentage_animation_timeline = gsap.timeline({
    scrollTrigger: {
        // scrub: 1,
        id: "pecentage",
        trigger: ".parent-percentage",
        // markers:true,
        start: "top center",
        toggleActions: "play none none none"
    }
});


percentage_animation_timeline
.from(".parent-percentage .percentage", {
    y: 200,
    opacity:0,
    duration:2,
    ease: "back(1)",
    stagger:{
        each: 0.2,
        from: "center",
    },  
})
.from(".percentage-title", {
    y: 100,
    opacity:0,
    duration:2,
    ease: "back(2)",
    
}, "<0.2")


gsap.from(".stats-card",  {
    opacity: 0,
    y: 120,
    scale: 0.8,
    duration: 2,
    ease: 'back(1)",'
});