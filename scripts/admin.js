function show_chg_pass()
{
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0,0);
    document.getElementById('full').style.pointerEvents="none";
    document.getElementById('pass1').style.display="block";
}
function show_cre_user()
{
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0,0);
    document.getElementById('full').style.pointerEvents="none";
    document.getElementById('pass2').style.display="block";
}
function show_del_user()
{
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0,0);
    document.getElementById('full').style.pointerEvents="none";
    document.getElementById('pass3').style.display="block";
}
var ad_id;
function verify(i)
{
    ad_id = i;
    var vall = document.getElementById(ad_id).value;
    $.ajax({
        url: 'helper4',
        method: 'post',
        data: 'ad_k='+vall
    }).done(function(veri){
        console.log(veri);
        if(veri == 1)
        {
            var remdis = document.querySelectorAll('.dis_all');
            for(var i =0;i<remdis.length;i++)
            {
                remdis[i].disabled=false;
            }
            document.getElementById(ad_id).style.borderWidth = "2px";
            document.getElementById(ad_id).style.borderColor = "green";
            document.getElementById(ad_id).disabled=true;
        }
        else{
            document.getElementById(ad_id).style.borderWidth = "4px";
            document.getElementById(ad_id).style.borderColor = "red";
        }
    })
}
function clo2(){
    document.getElementById('full').style.pointerEvents="all";
    document.getElementById('pass1').style.display="none";
    document.getElementById('pass2').style.display="none";
    document.getElementById('pass3').style.display="none";
    document.getElementById('cre_form').reset();
    document.getElementById('del_form').reset();
    document.getElementById('chg_form').reset();
    var remdis = document.querySelectorAll('.dis_all');
    for(var i =0;i<remdis.length;i++)
    {
        remdis[i].disabled=true;
    }
    document.getElementById('ad_kk').style.borderWidth = "1px";
    document.getElementById('ad_kk').style.borderColor = "grey";
    document.getElementById('ad_kk').disabled=false;
    document.getElementById('ad_kk1').style.borderWidth = "1px";
    document.getElementById('ad_kk1').style.borderColor = "grey";
    document.getElementById('ad_kk1').disabled=false;  
}
function slide(){
    document.getElementById("main").style.display="block";
    document.getElementById("mob-view").style.display="none";
    document.getElementById('full').style.display="none";
}
function clo1(){
    document.getElementById("main").style.display="none";
    document.getElementById("mob-view").style.display="block";
    document.getElementById('full').style.display="block";
}
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
}
function get_user_info()
{
var vall = "user_in";
$.ajax({
    url: 'helper4',
    method: 'post',
    data: 'user_in='+vall
}).done(function(user){
    console.log(user);
    user = JSON.parse(user);
    $('#users_det').empty();
    $('#users_det').append('<tr><th>Users</th><th>Last Logged In</th><th>Log Out</th><th>Last Visited Pages</th><th>Browser_Logged_in</th></tr>');
    user.forEach(function(users){
        $('#users_det').append('<tr><td>'+users.username+'</td><td>'+users.last_login+'</td><td>'+users.last_logout+'</td><td>'+users.last_accessed_page+'</td><td>'+users.user_browser+'</td></tr>');
    })
})
}
get_user_info();
function getall()
{
var vall = "all";
$.ajax({
    url: 'helper4',
    method: 'post',
    data: 'all='+vall
}).done(function(all){
    console.log(all);
    all = JSON.parse(all);
    $('#det').empty();
    $('#det').append('<tr><th>Syllabus</th><th>Class</th><th>Subject</th><th>Chapter</th><th>Topic</th><th>Concept</th><th>No. of MCQ\'s</th><th>No. of FIB</th></tr>');
    all.forEach(function(alls){
        $.ajax({
            url: 'helper4',
            method: 'post',
            data: 'con='+alls.concept_id
        }).done(function(mcq){
            console.log(mcq);
            mcq  = JSON.parse(mcq);
            $.ajax({
                url: 'helper4',
                method: 'post',
                data: 'con1='+alls.concept_id
            }).done(function(fib){
                console.log(fib);
                fib  = JSON.parse(fib);
                $('#det').append('<tr><td>'+alls.syllabus+'</td><td>'+alls.class+'</td><td>'+alls.subject+'</td><td>'+alls.chapter+'</td><td>'+alls.topic+'</td><td>'+alls.concept+'</td><td>'+mcq+'</td><td>'+fib+'</td></tr>');
            })
        })
    })
})
}
getall();
$(window).ready(function(){
    $.ajax({
        url: '../logout',
        method: 'post',
        data: 'logout=page_control_panel'
    })
})