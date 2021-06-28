lightSchemeIcon = document.querySelector('link#light-scheme-icon');
darkSchemeIcon = document.querySelector('link#dark-scheme-icon');
matcher = window.matchMedia('(prefers-color-scheme: dark)');
matcher.addListener(onUpdate);
onUpdate();

function onUpdate() {
if (matcher.matches) {
    lightSchemeIcon.remove();
    document.head.append(darkSchemeIcon);
} else {
    document.head.append(lightSchemeIcon);
    darkSchemeIcon.remove();
}

change = 0;

}
function home()
{
    var ty = confirm("Are You Sure , Click Ok to go to Home Page....");
    if(ty == true)
    {
        document.getElementById('homy').click();
    }
}
function opendis1(i,j,k)
{
    if(i.value == null)
    {
        alert("select opt");
    }else
    {
        document.getElementById(j).disabled=false;
        if(j == "mcq")
        {
            document.getElementById('fib').disabled=false;
        }
        if(k == 0)
        {
            var syl = $("#loadsyl").val();
            document.getElementById('loadsub').disabled=true;
            document.getElementById('loadchap').disabled=true;
            document.getElementById('loadtopic').disabled=true;
            document.getElementById('loadconc').disabled=true;
            showfill(2);
            $.ajax({
                url: 'helper',
                method: 'post',
                data: 'syl=' + syl
            }).done(function(cls){
                console.log(cls);
                cls = JSON.parse(cls);
                $('#loadcls').empty();
                $('#loadcls').append('<option disabled selected>--- Select Class ---</option>')
                cls.forEach(function(clss){
                    $('#loadcls').append('<option value="'+clss.class+'">'+clss.class+'</option>')
                })
                if(change == 1)
                {
                    $('#loadcls option[value="6"]').attr('selected','selected').change();
                }
            })
        }
        if(k == 1)
        {
            var cls = $("#loadcls").val();
            document.getElementById('loadchap').disabled=true;
            document.getElementById('loadtopic').disabled=true;
            document.getElementById('loadconc').disabled=true;
            showfill(2);
            $.ajax({
                url: 'helper',
                method: 'post',
                data: 'cls='+cls
            }).done(function(sub){
                console.log(sub);
                sub = JSON.parse(sub);
                $('#loadsub').empty();
                $('#loadsub').append('<option disabled selected>--- Select Subject ---</option>')
                sub.forEach(function(subs){
                    $('#loadsub').append('<option value="'+subs.subject+'">'+subs.subject+'</option>')
                })
                if(change == 1)
                {
                    $('#loadsub option[value="'+variables[2]+'"]').attr('selected','selected').change();
                }
            })
        }
        if(k == 2)
        {
            var sub = $("#loadsub").val();
            document.getElementById('loadtopic').disabled=true;
            document.getElementById('loadconc').disabled=true;
            showfill(2);
            $.ajax({
                url: 'helper',
                method: 'post',
                data: 'sub='+sub
            }).done(function(chap){
                console.log(chap);
                chap = JSON.parse(chap);
                $('#loadchap').empty();
                $('#loadchap').append('<option disabled selected>--- Select Chapter ---</option>')
                chap.forEach(function(chaps){
                    $('#loadchap').append('<option value="'+chaps.chapter+'">'+chaps.chapter+'</option>')
                })
                if(change == 1)
                {
                    $('#loadchap option[value="'+variables[3]+'"]').attr('selected','selected').change();
                }
            })
        }
        if(k == 3)
        {
            var chap = $("#loadchap").val();
            document.getElementById('loadconc').disabled=true;
            showfill(2);
            $.ajax({
                url: 'helper',
                method: 'post',
                data: 'chap='+chap
            }).done(function(topic){
                console.log(topic);
                topic = JSON.parse(topic);
                $('#loadtopic').empty();
                $('#loadtopic').append('<option disabled selected>--- Select Topic ---</option>')
                topic.forEach(function(topics){
                    $('#loadtopic').append('<option value="'+topics.topic+'">'+topics.topic+'</option>')
                })
                if(change == 1)
                {
                    $('#loadtopic option[value="'+variables[4]+'"]').attr('selected','selected').change();
                }
            })
        }
        if(k == 4)
        {
            var topic = $("#loadtopic").val();
            $.ajax({
                url: 'helper',
                method: 'post',
                data: 'topic='+topic
            }).done(function(conc){
                console.log(conc);
                conc = JSON.parse(conc);
                $('#loadconc').empty();
                $('#loadconc').append('<option disabled selected>--- Select Concept ---</option>')
                conc.forEach(function(concs){
                    $('#loadconc').append('<option value="'+concs.concept+'">'+concs.concept+'</option>')
                })
                document.getElementById('fib').checked=false;
                document.getElementById('mcq').checked=false;
                if(change == 1)
                {
                    $('#loadconc option[value="'+variables[5]+'"]').attr('selected','selected').change();
                }
            })
        }
        if(k == 5)
        {
            var conc = $("#loadconc").val();
            $.ajax({
                url: 'helper',
                method: 'post',
                data: 'conc='+conc
            })
            if(change == 1)
            {
                document.getElementById(variables[6]).click();
                change = 0;
            }
        }
    }
}
function showfill(i)
{
    if(i == 0)
    {
        document.getElementById('nothing').style.display="none";
        document.getElementById('openfillups').style.display="none";
        document.getElementById('openmcq').style.display="block"; 
        resetform();
    }else if(i == 1)
    {
        document.getElementById('nothing').style.display="none";
        document.getElementById('openmcq').style.display="none";
        document.getElementById('openfillups').style.display="block";
        resetform();
    }
    else
    {
        document.getElementById('nothing').style.display="block";
        document.getElementById('openmcq').style.display="none";
        document.getElementById('openfillups').style.display="none";
        document.getElementById('fib').disabled=true;
        document.getElementById('mcq').disabled=true;
        document.getElementById('fib').checked=false;
        document.getElementById('mcq').checked=false;
        resetform();
    }
}
function resetform()
{
    document.getElementById('f1').reset();
    document.getElementById('f2').reset();
    document.getElementById('eqs1').style.display='none';
    document.getElementById('eqs2').style.display='none';
    delimg();
    delimg2();
}
var r = 2,rr=4;
var alp = ['c','d','e','f','g','h','i','j'];
function addopt()
{
    if(r>7)
    {
        alert("Only 6 extra options can be added !!!!");
    }else
    {
        var table = document.getElementById("choice");
        var row = table.insertRow(rr);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        rr+=1;
        cell1.innerHTML = "option ("+alp[r]+")";
        cell2.innerHTML = "<input type='text' title='option-"+rr+"' autocomplete='off' required name='opt"+rr+"' id='opt"+rr+"'>";
        cell3.innerHTML = "<input type='checkbox' title='Select if entered option is correct' value='crt' name=c"+rr+">";
        cell4.innerHTML = "<span id='eopt"+rr+"'></span>"
        r+=1;
        document.getElementById('submcq').value = (rr);
    }
}
function remopt()
{
    if(rr<3)
    {
        alert("MCQ Question requires atleat 2 options !!!!");
    }else
    {
        var table = document.getElementById("choice");
        table.deleteRow(rr-1);
        rr-=1;
        r-=1;
        document.getElementById('submcq').value = (rr);
    }
}
$(document).ready(function(){
    $("#mcq").click(function(){
        var vall = $("#mcq").val();
        $.ajax({
            url: 'helper',
            method: 'post',
            data: 'mcq='+vall
        })
    })
})
$(document).ready(function(){
    $("#fib").click(function(){
        var vall = $("#fib").val();
        $.ajax({
            url: 'helper',
            method: 'post',
            data: 'fib='+vall
        })
    })
})

var clear;
var _URL = window.URL;
//Image Questions
$(document).ready(function () {
    $(".ques_img").change(function () {
        document.getElementById('img').style.display="block";
        document.getElementById('errim').style.display="none";
        var fullPath = document.querySelector('.ques_img').value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            document.getElementById('img_path').placeholder = filename;
        }


        const file2 = this.files[0];
        if (file2) {
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                console.log(this);
                $("#img").attr("src", this.result);
            })

            reader.readAsDataURL(file2);
        }
        var k = document.querySelector(".ques_img");
        if (k.files.length == 0) {
            null;
        } else {
            document.getElementById('taa').value = "Image Question";
            document.getElementById('taa').disabled = true;
            document.getElementById('eqbut1').disabled=true;
            document.getElementById('view1').disabled=true;
            document.getElementById('isequation1').disabled=true;
            document.getElementById('isequation1').checked=false;
        }
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|)$/i;
        if (!allowedExtensions.exec(fullPath)) {
            alert('Invalid file type');
            document.getElementById('img').style.display="none";
            document.getElementById('errim').style.display="block";
            delimg();
            return 0;
        }

        var file, img;
        if ((file = document.querySelector('.ques_img').files[0])) {
            img = new Image();
            img.onload = function () {
                alert("Width:" + this.width + "   Height: " + this.height);
                if (this.width > 1000 || this.height > 1000) {
                    alert("Dimensions are Not Compatible");
                    delimg();
                    return 0;
                }
            };
            img.src = _URL.createObjectURL(file);
        }
    })
})
function delimg()
{
     document.getElementById("img_path").placeholder = "Select File !!!!";
     document.getElementById('taa').value = "";
     document.getElementById('taa').placeholder = "Enter MCQ's Questions....";
     document.querySelector(".ques_img").value = null;
     document.getElementById('taa').disabled = false;
     document.getElementById('eqbut1').disabled=true;
     document.getElementById('view1').disabled=true;
     document.getElementById('isequation1').disabled=false;
     document.getElementById('isequation1').checked=false;
     $("#img").attr("src","../images/immg.png");
}




$(document).ready(function(){
    $("#ques_img_fib").change(function(){
    var fullPath = document.querySelector('#ques_img_fib').value;
    if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        var filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
        document.getElementById('path_img_fib').placeholder = filename;
    }
    const file1 = this.files[0];
    if(file1){
    const reader = new FileReader();
    reader.addEventListener("load",function(){
        console.log(this);
        $("#img2").attr("src",this.result);
    })      
    
    reader.readAsDataURL(file1);
    }
    var k = document.querySelector("#ques_img_fib");
    if(k.files.length == 0)
    {
        null;
    }else
    {
        document.getElementById('taa2').value = "Image Question";
        document.getElementById('taa2').disabled = true;
        document.getElementById('eqbut2').disabled=true;
        document.getElementById('view2').disabled=true;
        document.getElementById('isequation2').disabled=true;
        document.getElementById('isequation2').checked = false;
    }

    var allowedExtensions = /(\.jpg|\.jpeg|\.png|)$/i;
    if (!allowedExtensions.exec(fullPath)) {
        alert('Invalid file type');
        document.getElementById('img2').style.display="none";
        document.getElementById('errim2').style.display="block";
        delimg2();
        return 0;
    }

    var file, img;
    if ((file = document.getElementById('ques_img_fib').files[0])) {
        img = new Image();
        img.onload = function () {
            alert("Width:" + this.width + "   Height: " + this.height);
            if(this.width > 1000 || this.height > 1000)
            {
                alert("Dimensions are Not Compatible");
                delimg2();
            }
        };
        img.src = _URL.createObjectURL(file);
    }
})
})
function delimg2()
{
    document.getElementById("path_img_fib").placeholder = "Select File !!!!";
     document.getElementById('taa2').value = "";
     document.getElementById('taa2').placeholder = "Enter Questions....";
     document.querySelector("#ques_img_fib").value = null;
     document.getElementById('taa2').disabled = false;
     document.getElementById('eqbut2').disabled=true;
     document.getElementById('view2').disabled=true;
     document.getElementById('isequation2').disabled=false;
     document.getElementById('isequation2').checked = false;
    $("#img2").attr("src","../images/immg.png");
}
function openequ(i)
{
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0,0);
    $('body').addClass('stop-scrolling');
    document.getElementById('full').style.pointerEvents="none";
    document.getElementById('equ').style.display="block";
    document.getElementById('ins').value=i;
}
var bo = [false,true],boo=0;
function openeqbut(id1,id2,id3,id4,type)
{
    if(boo == 0)
    {
        document.getElementById(id1).disabled=bo[boo];
        document.getElementById(id2).disabled=bo[boo];
        document.getElementById('renopt').style.display="inline-block";
        document.getElementById('renopt2').style.display="block";
        boo = 1;
    }else
    {
        document.getElementById(id1).disabled=bo[boo];
        document.getElementById(id2).disabled=bo[boo];
        document.getElementById(id3).value = "";
        document.getElementById(id4).style.display="none";
        document.getElementById('renopt').style.display="none";
        document.getElementById('renopt2').style.display="none";
        if(type == "mcq")
        {
            for(var i=1;i<=rr;i++)
            {
                document.getElementById('opt'+i).value = "";
                document.getElementById('eopt'+i).innerHTML = "";
            }
        }else
        {
            document.getElementById('fibans').value = "";
            document.getElementById('efibans').innerHTML = "";
        }
        boo = 0;
    }
}