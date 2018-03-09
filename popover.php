<script type="text/javascript" src="//code.jquery.com/jquery-1.8.3.js"></script>
<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />  
<link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.css">
    


<script type='text/javascript'>//<![CDATA[

$(function(){
    $('#login').popover({
       
        placement: 'bottom',
        html:true,
        content:  $('#myForm').html()
    }).on('click', function(){
      // had to put it within the on click action so it grabs the correct info on submit
      $('.btn-primary').click(function(){
	   $('#login').popover('hide');
       $('#result').after("form submitted by " + $('#email').val())
        $.post('/echo/html/',  {
            email: $('#email').val(),
            name: $('#name').val(),
            gender: $('#gender').val()
        }, function(r){
          //$('#pops').popover('hide');
		  $('#result').html('resonse from server could be here' );
        })
      })
    })

})

//]]> 

</script>

  
<div class="well col-offset-5">
    <button type="button" id="login" class="btn">Login sign up Form</button>
</div>

<div class="well col-offset-5">
    <button type="button" id="login" class="btn">Login 2</button>
</div>

<div id="myForm" class="hide">
    <form action="/echo/html/" id="popForm" method="get">
		<div>Schedule It <a href="#" class="close" onclick="$('#login').popover('hide');"><i class="fa fa-times" aria-hidden="true"></i></a></div>
		<hr>
        <div>
		    Email: <input type="email" name="email" id="email" class="form-control input-sm">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control input-md">
            <label for="denger">Gender:</label>
            <select name="gender" id="gender" class="form-control input-md"><option value="male">Male</option><option value="female">Female</option></select>
            <label for="about">About Me:</label>
            <textarea rows="3" name="about" id="about" class="form-control input-md"></textarea>
            <button type="button" class="btn btn-primary" data-loading-text="Sending info.."><em class="icon-ok"></em> Save</button>
        </div>
    </form>
	
</div>

<div id="result"></div>

<div id="result2"></div>

