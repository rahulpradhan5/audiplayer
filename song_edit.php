<h2>Edit Song</h2>
            <div class="form-element">
                <label>Title</label>
                <input type="text" class="song_name" id="title" placeholder="Enter Title" require>
            </div>
            <div class="form-element">
                <label>Artist</label>
                <input type="text" class="artist" id="artist" placeholder="Enter artist name" require>
            </div>
            <div class="select ">
                <label>Playlist</label>
                <select class="sele" name="playlist" id="playlist" style="width: 320px;" multiple>
                    <option value="hi">Hii</option>
                    <option value="hii">Hii</option>
                    <option value="hiii">Hii</option>
                </select>
                <script>
                    $(".sele").select2({
                        maximumSelectionLength: 6,
                    });
                   
                </script>
            </div>
            <div class="form-element">
                <label>Song</label>
                <input type="file" id="song" placeholder="Enter Title" hidden="hidden" require>
                <div class="custom-choose">
                    <button type="button" class="uplaod_song_button " id="uplaod_song_button" style="width: 40%;">Choose</button>
                    <span class="custum-text song" id="custum-text">No song choosen,yet</span>
                </div>
            </div>
            <div class="form-element">
                <label>Thumbnail</label>
                <input type="file" id="thumbnail" placeholder="Enter Title" hidden="hidden" require>
                <div class="custom-choose">
                    <button type="button" class="uplaod_song_button " id="thumb_btm" style="width: 40%;">Choose</button>
                    <span class="custum-text thumb" id="thumb_text">No song choosen,yet</span>
                </div>
            </div>
            <div class="form-element">
                <button id="submit">Upload</button>
            </div>