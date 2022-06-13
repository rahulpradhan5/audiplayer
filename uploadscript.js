  // custom select file
  const realfilebtn = document.getElementById("song");
  const custombtn = document.getElementById("uplaod_song_button");
  const customtxt = document.getElementById("custum-text");
  const thumbfilebtn = document.getElementById("thumbnail");
  const thumbbtn = document.getElementById("thumb_btm");
  const thumbtxt = document.getElementById("thumb_text");

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

  $(document).ready(function() {
      // song file save js
      $(document).on('change', '#song', function() {

          var property = document.getElementById("song").files[0];
          var song_name = property.name;
          var song_extension = song_name.split(".").pop().toLowerCase();
          if (song_extension !== 'mp3') {
              alert("Invalid Audio Formate");
              $("#submit").prop('disabled', true);
          } else {
              var from_data = new FormData();
              from_data.append("song", property);
              $.ajax({
                  url: "file_upload.php",
                  method: "POST",
                  data: from_data,
                  contentType: false,
                  cache: false,
                  processData: false,
                  beforeSend: function() {
                      $("#custum-text").html("uplaoding...");
                      $("#submit").prop('disabled', true);

                  },
                  success: function(data) {
                      console.log(data);
                      if (data == "failed") {
                          alert("Failed Try Again")
                      } else {
                          $("#custum-text").html(data);
                          $("#submit").prop('disabled', false);
                      }
                  }
              });
          }
      });

      // thumbanil file save js

      $(document).on('change', '#thumbnail', function() {
          var tproperty = document.getElementById("thumbnail").files[0];
          var image_name = tproperty.name;
          var image_extension = image_name.split(".").pop().toLowerCase();
          console.log(image_extension);
          if (image_extension !== 'gif' && image_extension !== 'png' && image_extension !== 'jpg' && image_extension !== 'svg' && image_extension !== 'jpeg') {
              alert("Invalid File Formate");
              $("#submit").prop('disabled', true);
          } else {
              var from_data = new FormData();
              from_data.append("thumbnail", tproperty);
              $.ajax({

                  url: "thumbanilupload.php",
                  method: "POST",
                  data: from_data,
                  contentType: false,
                  cache: false,
                  processData: false,
                  beforeSend: function() {
                      $("#thumb_text").html("uplaoding...");
                      $("#submit").prop('disabled', true);

                  },
                  success: function(data) {
                      console.log(data);
                      if (data == "failed") {
                          alert("Failed Try Again")
                      } else {
                          $("#thumb_text").html(data);
                          $("#submit").prop('disabled', false);
                      }
                  }
              });
          }
      });


      // send data into db
      $("#submit").click(function(e) {
          e.preventDefault();
          var title = $(".song_name").val();
          var artist = $(".artist").val();
          var song = $(".song").html();
          var songIn = $("#song").val();
          var song_extension = songIn.split(".").pop().toLowerCase();
          var thumbanail = $(".thumb").html();
          var image_extension = thumbanail.split(".").pop().toLowerCase();
          var thumbIn = $("#thumbnail").val();
          if (title == "" || artist == "" || songIn == "" || thumbIn == "") {
              alert("All Fields are require");
          } else if (image_extension !== 'gif' && image_extension !== 'png' && image_extension !== 'jpg' && image_extension !== 'svg' && image_extension !== 'jpeg') {
              alert("Invalid Image Formate");
              $("#submit").prop('disabled', true);
          } else if (song_extension !== 'mp3') {
              alert("Invalid Audio Formate");
              $("#submit").prop('disabled', true);
          } else {
              $("#submit").prop('disabled', false);
              $.ajax({
                  url: "all.php",
                  type: "post",
                  data: {
                      sub: 1,
                      name: title,
                      artist: artist,
                      song: song,
                      thumb: thumbanail
                  },
                  success: function(data) {
                      console.log(data);
                      if (data = "success") {
                          $(".close-btn").click();
                          $(".list-songs").load("search.php");
                          alert("success");
                      } else if(data == 'faield'){
                          alert("failed");
                      }
                  },
              });
          }
      });
  });

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
  $(".plalist-image").click(function() {
      var fid = $(this).attr('id');
      var pname = $(this).attr('value');
      $.ajax({
          url: "search.php",
          data: {
              playlist: 1,
              pid: fid
          },
          type: "post",
          success: function(data) {
              console.log(data);
              $(".list-songs").html(data);
              $(".all-songs").html("Playlist name '" + pname + "'");
          }
      })
  })

  // serach animation

  let i = 0;
  let placeholder = "";
  const txt = document.getElementById("search-input").placeholder;
  const speed = 120;

  function type() {
      placeholder += txt.charAt(i);
      document.getElementById("search-input").setAttribute("placeholder", placeholder);
      i++;
      setTimeout(type, speed);
  }

  //search animation
  var search = document.querySelector("#search");

  function seach() {
      i = 0;
      placeholder = "";
      search.classList.add("search-active");
      document.querySelector(".search-span").classList.add("search-span-dactive");
      document.querySelector(".search-input-i").classList.add("search-input-i-active");
      document.querySelector(".search-input").classList.add("search-input-active");
      type();
  }