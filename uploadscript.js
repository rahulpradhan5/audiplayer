  // custom select file
  const realfilebtn = document.getElementById("song");
  const custombtn = document.getElementById("uplaod_song_button");
  const customtxt = document.getElementById("custum-text");
  const thumbfilebtn = document.getElementById("thumbnail");
  const thumbbtn = document.getElementById("thumb_btm");
  const thumbtxt = document.getElementById("thumb_text");

   
    //------------------------
  custombtn.addEventListener("click", function() {
      realfilebtn.click();

  });

  realfilebtn.addEventListener("change", function() {
      if (realfilebtn.value) {
          customtxt.innerHTML = realfilebtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
      } else {
          customtxt.innerHTML = "No file choosen,yet";
      }
  });

  thumbbtn.addEventListener("click", function() {
      thumbfilebtn.click();

  });

  thumbfilebtn.addEventListener("change", function() {
      if (thumbfilebtn.value) {
          thumbtxt.innerHTML = thumbfilebtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
      } else {
          thumbtxt.innerHTML = "No file choosen,yet";
      }
  });

  //  add song popup

  document.querySelector("#show-login").addEventListener("click", function() {
      document.querySelector(".popup").classList.add("active");

  });
  document.querySelector(".popup .close-btn").addEventListener("click", function() {
      document.querySelector(".popup").classList.remove("active");

  });
  /// song list 
  document.querySelector("#all-songs-list").addEventListener("click", function() {
      document.querySelector(".song_list").classList.add("active");

  });
  document.querySelector(".song_list .close-btn").addEventListener("click", function() {
      document.querySelector(".song_list").classList.remove("active");
      document.querySelector("#search").classList.remove("search-active");
      document.querySelector(".search-span").classList.remove("search-span-dactive");
      document.querySelector(".search-input-i").classList.remove("search-input-i-active");
      document.querySelector(".search-input").classList.remove("search-input-active");
  });

  document.querySelector("#edit-song").addEventListener("click", function() {
      document.querySelector(".edit-popup").classList.add("active");
      $(".edit-form").load("song_edit.php");

  });
  document.querySelector(".edit-popup .close-btn").addEventListener("click", function() {
      document.querySelector(".edit-popup").classList.remove("active");
  });
  
  //send data to all .php

 
  // play all song 
  function searchData() {
      var inputs = $("#search-input").val();
      $.ajax({
          url: "search.php",
          method: "POST",
          data: {
              search: 1,
              inputs: inputs
          },
          success: function(data) {
              console.log(data);
              $(".list-songs").html(data);
              $(".all-songs").html("Search result for '" + inputs + "'");
          }
      });
  }

  // Delete a song data------------------

  function songDelete(data_id) {
      $.ajax({
          url: "all.php",
          data: {
              delete: 1,
              sid: data_id
          },
          type: "post",
          success: function(data) {
              console.log(data);
              if (data == "failed") {
                  alert("Failed");
              } else {
                  alert("Succesfully Deleted Song Permanently");
                  $(".list-songs").load("search.php");
              }
          }
      })
  }

  // paly all song

  /// load playlist song...............-------
  

  // serach animation

  var i = 0;
  var placeholder = "";
  const txt = document.getElementById("search-input").placeholder;
  const speed = 120;

  function type() {
    
      placeholder += txt.charAt(i);
      document.getElementById("search-input").setAttribute("placeholder", placeholder);
      i++;
      setTimeout(type, speed);
  }

  //search animation
  

  function seach() {
     var i = 0;
     var search = document.querySelector("#search");
      placeholder = "";
      search.classList.add("search-active");
      document.querySelector(".search-span").classList.add("search-span-dactive");
      document.querySelector(".search-input-i").classList.add("search-input-i-active");
      document.querySelector(".search-input").classList.add("search-input-active");
      type();
  }

