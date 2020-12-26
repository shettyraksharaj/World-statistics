<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>World statistics</title>
  <?php require 'iniconfig.php'; ?>
</head>

<body>
  <video src="bckvid.mp4 " class="position-fixed bckimg" autoplay="autoplay" loop="loop">
  </video>
  <div class="container mt-5">
    <div class="row align-items-start">
      <h1 class="col display-1 text-center text-white font-weight-bold">WORLD STATISTICS</h1>
    </div>
    <div class="row align-items-center moresty">
      <form class="mainform" method="post">
        <div class="form-group dropdown">
          <input class="form-control form-control-lg ser dropdown-toggle" type="text" id="searchbar" placeholder="Country name..." data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="dropdown-menu" aria-labelledby="searchbar" style="width:100%; margin-top:-1px" id='serresdisplay'>
          </div>
        </div>
      </form>
    </div>
  </div>
  <span href="#" class="container position-fixed viewbar ">
    <div class="position-relative">
      <pre class="row text-white justify-content-center text-decoration-none mar"><!--add js for exit animation-->
c

h

a

n

g

e


v

i

e

w
</pre>
    </div>
  </span>
  <footer class="fixed-bottom">
    <div class="row">
      <a class="mx-auto text-white text-decoration-none" href="wldstatadminlogin.php"> Admin? </a>
    </div>
  </footer>
  <script>
    $(document).ready(function() {
      $.post('getdata.php', function(data) {
        var jdata = JSON.parse(data);
        var count = jdata.length;
        console.log(jdata);
        $('#searchbar').keyup(function() {
          $('.dropdown-item').remove();
          var linkno = 0;
          var regex = new RegExp($('#searchbar').val(),'i');
          for (var i = 0; i < count; i++) {
            if(linkno>7){
              continue;
            }else{
              linkno++;
            }
            if (regex.test(jdata[i].COUNTRY_NAME)) {
              $('#serresdisplay').append('<a class="dropdown-item" id="'+jdata[i].COUNTRY_NAME+'" href="#">'+jdata[i].COUNTRY_NAME+'</a>')
            }else{
            }
          }
        })

      });
    })
  </script>
</body>

</html>