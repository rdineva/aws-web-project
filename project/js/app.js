let wrapper = document.getElementById("animation-wrapper");
let animation = document.getElementsByClassName("content")[0];
let speed = Number(document.getElementById("speed").innerHTML);
let starWars = document.getElementsByClassName("star-wars");
let pxBySecond = 30 * speed;
let height = animation.offsetHeight;

if (starWars) {
    height = animation.offsetWidth * 5;
}
if (wrapper) {
    console.log('works');
    let duration = ( height / pxBySecond);
    console.log(height)
    animation.style.animationDuration = duration + "s"; 
}

let playButton = document.getElementById("play");

if (playButton) {
    playButton.addEventListener('click', alterAnimation);
}

function alterAnimation() {
    let state = animation.style.animationPlayState;
    let playIcon = document.querySelector(".img-container.play");
    let pauseIcon = document.querySelector(".img-container.pause");

    if (state == "running") {
        animation.style.animationPlayState = "paused";
        playIcon.style.display = "block";
        pauseIcon.style.display = "none";
    }
    else {
        animation.style.animationPlayState = "running";
        playIcon.style.display = "none";
        pauseIcon.style.display = "block";
    }
}