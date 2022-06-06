let previous = document.querySelector('#pre');
let play = document.querySelector('#play');
let next = document.querySelector('#next');
let title = document.querySelector('#title');
let recent_volume = document.querySelector('#volume');
let volume_show = document.querySelector('#volume_show');
let slider = document.querySelector('#duration_slider');
let show_duration = document.querySelector('#show_duration');
let track_image = document.querySelector('#track_image');
let auto_play = document.querySelector('#auto');
let present = document.querySelector('#present');
let total = document.querySelector('#total');
let artist = document.querySelector('#artist');
let lastNO = document.querySelector('#last').value;
var jsmediatags = window.jsmediatags;

let timer;
let autoplay = 0;
let id = false;
let done;
let index_no ;
let sno;
let psong = false;
// check last index of last time play song
if(sno !== 0){
    sno = index_no_l;
}else{
    sno = 1;
}
let playin_song = false;



// creat  a audio Element

let track = document.createElement('audio');


// check last time of last time play song
if(currentTime_l !== 0){
    track.currentTime = currentTime_l;
}

// all function

// load data dynamicly
function loadData(sno){
    $.ajax({
        url:"data.php",
        data:{data:1,index:sno,lastsno:lastNO},
        type:"post",
        success:function(data){
            console.log(data);
            if(data == "failed"){
            sno = sno+1;
            loadData(sno);
        }else{
             $(".dt").html(data)
        }
        }
    })
}
loadData(sno);
let t = 0;
let lno;
//function load the track
function load_track(t,sno,lno){
    
    console.log(done[t].path);

    
    clearInterval(timer)
    reset_slider()
    track.src = done[t].path;
    title.innerHTML = done[t].name;
    track_image.src = done[t].img;
    artist.innerHTML = done[t].singer;
    track.load();  
    imageExtract(track.src);
    total.innerHTML = lno;
    present.innerHTML = sno;
    timer = setInterval(range_slider , 1000);
}

load_track(t,sno,lno);
/* -----------------------------------------------------------------
// image extracter from audio----------------------
--------------------------------------------------------------------*/
function imageExtract(){
    jsmediatags.read((track.src), {
    onSuccess: function(tag) {
     const pdata = tag.tags.picture.data;
     const format = tag.tags.picture.formate;
     let base64String = "";
     for(let p = 0; p<pdata.length;p++ ){
         base64String += String.fromCharCode(pdata[p]);

     }
     track_image.src = `data:${format};base64,${window.btoa(base64String)}`;
    }
})
}
//mute song

function mute_sound(){
    track.volume = 0;
    volume.value = 0;
    volume_show.innerHTML = 0;

}


//reset slider 
 function reset_slider(){
     slider.value = 0;
 }

// checking the song is playing or not

function justplay(){
    if(playin_song == false){
        playsong();
    }else{
        pausesong();
    }
}

//play song
function playsong(){
    track.play();
    playin_song = true;
    play.innerHTML = '<i class="fa fa-pause"> </i>';
}

//pause dong
function pausesong(){
    track.pause();
    playin_song = false;
    play.innerHTML = '<i class="fa fa-play"> </i>';
}

//next song
function next_song(){
    playin_song = false;
        sno += 1;
        loadData(sno);
        psong = true;
        playsong();
        
}

//previous song
function previous_song(){
    playin_song = false;
        sno -= 1;
        psong = true;
        loadData(sno);
}

//change volume

function volume_change(){
    volume_show.innerHTML = recent_volume.value;
    track.volume = recent_volume.value / 100;

}

//change slider 

function change_duration(){
    slider_position = track.duration * (slider.value / 100 );
    track.currentTime = slider_position;

}

 //autopaly function
    
function autoplay_switch(){
    if(autoplay == 1){
        autoplay = 0;
        auto_play.style.background = "rgba(255,255,255,0.2)";
    }else{
        autoplay = 1;
        auto_play.style.background ="#FF8A65";
    }
}

function range_slider(){
    let position = 0;
    
    //update position
    if(!isNaN(track.duration)){
        position = track.currentTime * (100 / track.duration);
        slider.value = position;
        $.ajax({
            url: "timeupdate.php",
            method: "POST",
            data: {
                up: 1,
                indexNo: sno,
                lastTime: track.currentTime
            },
            success: function(data) {
            console.log(data);
            }
        });
    }

   

    // function will run when song is over

    if(track.ended){
        play.innerHTML = '<i class="fa fa-play"></i>';
        if(autoplay == 1){
            
            if(sno == lastNO){
                sno = 1
                psong = true;
            }else if(sno >= 0){
                sno += 1;
                psong = true;
            }
            loadData(sno);
            playsong()
        }
    }
}

// play all song
function play_all(){
    index_no = 0;
     all_song = [
    {
        name: "rahul",
            path: "audio/Sajnaa.mp3",
            img: "image/saajna.jpg",
            singer: "rahul"
    },
    {
        name: "prahul",
            path: "audio/Sajnaa.mp3",
            img: "image/saajna.jpg",
            singer: "rahul"
    }
    ];
    clearInterval(timer)
    reset_slider()
    track.src = all_song[index_no].path;
    title.innerHTML = all_song[index_no].name;
    track_image.src = all_song[index_no].img;
    artist.innerHTML = all_song[index_no].singer;
    track.load();  
    
    total.innerHTML = all_song.length;
    present.innerHTML = index_no + 1;
    timer = setInterval(range_slider , 1000);  
    load_track(index_no);
    playsong();
    console.log(track);
    
}

let i = 0;
let placeholder = "";
const txt = document.getElementById("search-input").placeholder;
const speed = 120;

function type(){
    placeholder += txt.charAt(i);
    document.getElementById("search-input").setAttribute("placeholder",placeholder);
        i++;
    setTimeout(type,speed);
}

//search animation
var search = document.querySelector("#search");
        function seach(){
            i = 0;
            placeholder = "";
            search.classList.add("search-active");
            document.querySelector(".search-span").classList.add("search-span-dactive");
            document.querySelector(".search-input-i").classList.add("search-input-i-active");
            document.querySelector(".search-input").classList.add("search-input-active");
            type();
        }