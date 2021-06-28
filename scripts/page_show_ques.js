var nochangeactive = 0;
var answer_f="0";
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
                url: 'helper1',
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
                    $('#loadcls option[value="'+variables[1]+'"]').attr('selected','selected').change();
                }
            })
        }
        if(k == 1)
        {
            //2
            var cls = $("#loadcls").val();
            document.getElementById('loadchap').disabled=true;
            document.getElementById('loadtopic').disabled=true;
            document.getElementById('loadconc').disabled=true;
            showfill(2);
            $.ajax({
                url: 'helper1',
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
        //3
            var sub = $("#loadsub").val();
            document.getElementById('loadtopic').disabled=true;
            document.getElementById('loadconc').disabled=true;
            showfill(2);
            $.ajax({
                url: 'helper1',
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
        //4
        var chap = $("#loadchap").val();
        document.getElementById('loadconc').disabled=true;
        showfill(2);
        $.ajax({
            url: 'helper1',
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
        //5
        var topic = $("#loadtopic").val();
        $.ajax({
            url: 'helper1',
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
            if(change == 1)
            {
                $('#loadconc option[value="'+variables[5]+'"]').attr('selected','selected').change();
                change = 1;
            }
        })
        }
        if(k == 5)
        {
        //6
        document.getElementById('nothing').style.display="block";
        document.getElementById('openmcq').style.display="none";
        document.getElementById('openfillups').style.display="none";
        document.getElementById('openshowall').style.display="none";
        document.getElementById('fib').checked=false;
        document.getElementById('mcq').checked=false;
        resetform();
        var conc = $("#loadconc").val();
        $.ajax({
            url: 'helper1',
            method: 'post',
            data: 'conc='+conc
        })
        if(change == 1)
        {
            document.getElementById(variables[6]).click();
            if(change == 1)
            {
                change = 1;
            }
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
        showww(1);
        resetform();
    }
}
function resetform()
{
    document.getElementById('f1').reset();
    document.getElementById('f2').reset();
}
var r = 0,rr=2;
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
        cell2.innerHTML = "<input type='text' autocomplete='off' required id='option"+rr+"' name=opt"+rr+">";        
        cell3.innerHTML = "<input type='checkbox' value='crt' id='choice"+rr+"' name=c"+rr+">";
        cell4.innerHTML = "<span id='eopt"+rr+"'></span>";
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
function showww(i)
{
    if(i == 0)
    {
        document.getElementById('nothing').style.display="none";
        document.getElementById('openmcq').style.display="none";
        document.getElementById('openfillups').style.display="none";
        document.getElementById('openshowall').style.display="block";
    }else
    {
        document.getElementById('nothing').style.display="block";
        document.getElementById('openmcq').style.display="none";
        document.getElementById('openfillups').style.display="none";
        document.getElementById('fib').disabled=true;
        document.getElementById('mcq').disabled=true;
        document.getElementById('openshowall').style.display="none";
    }
}

var ques_no = 1,kk = 0,samp;
let all_t = 0;
function sample(a,i)
{
    if(a == 1)
        ques_no += 1;
        p_mcq_q(i += 1);
}
function p_mcq_q(i)
{
    $('#show_all').empty();
    nochangeactive = 0;
    $.ajax({
        url: 'helper1',
        method: 'post',
        data: 'q_id_try=' + qu_ids[i]
    }).done(function (ans) 
    {
        console.log(ans);
        ans = JSON.parse(ans);
        var m = 1;
        ans.forEach(function (anss) 
        {
            if (m == 1) {
                if (anss.uplo_ques_type == "img") {
                    var sho = "<br><img src='" + anss.question + "' width='200px' height='200px' style='pointer-events:none'><br>"
                } else if (anss.uplo_ques_type == "eqn") {
                    var sho = "<br><span id='print_eqn" + ques_no + "'></span>";
                    document.getElementById('only_print').value = anss.question;
                    $('#only_p_but').attr("value", "print_eqn" + ques_no);
                    kk = 1;
                } else {
                    var sho = anss.question;
                }
                $('#show_all').append('<tr><td>Question.Id : ' + anss.question_id + '</td></tr><tr><td>(' + ques_no + ')</td></tr><tr><td>Question : ' + sho + '</td></tr><tr><td>answer : ')
                if (kk == 1) {
                    document.getElementById('only_p_but').click();
                }
                samp = 1;
            }

            if (anss.correct_flag == "crt") {
                var sym = "✔";
            } else {
                var sym = "✖";
            }
            if (anss.uplo_ques_type == "eqn") {
                var oopt = "<span id='print_opt" + anss.question_id + samp + "'></span>";
                document.getElementById('eqn_print_opt').value = anss.options;
                $('#opt_p_but').attr("value", "print_opt" + anss.question_id + samp);
            } else {
                var oopt = anss.options;
            }
            $('#show_all').append('option ' + anss.option_id + ' : ' + oopt + '  ' + sym + '<br>')
            if (kk == 1) {
                document.getElementById('opt_p_but').click();
                samp += 1;
            }
            if (m == ans.length) {
                samp = 1;
                if (anss.uplo_ques_type == "eqn") {
                    var expp = "<span id='print_exp" + anss.question_id + samp + "'></span>";
                    document.getElementById('eqn_print_exp').value = anss.explanation;
                    $('#exp_p_but').attr("value", "print_exp" + anss.question_id + samp);
                } else {
                    var expp = anss.explanation;
                }
                $('#show_all').append('</td></tr><tr><td>Explanation : ' + expp + '</td></tr><tr><td>Status : <select name="' + anss.question_id + '" id="fstat" onchange="chcolo(this,1)"><option value="approved" style="color: green;">Approved</option><option value="pending" style="color: red;">Pending</option><option value="rework" style="color: blue;">Rework</option></select></td></tr><tr style="border-bottom: 2px solid black;"><td align="center"><button type="button" onclick="editmode1(' + anss.question_id + ')">Edit</button>&emsp;<button type="button" onclick="deleteques(' + anss.question_id + ')">Delete</button></td></tr>')
                if (kk == 1) {
                    document.getElementById('exp_p_but').click();
                    samp += 1;
                }
                nochangeactive = 0;
                var stst = anss.ques_status;
                $('select[name="' + anss.question_id + '"]').val(stst).change();
                nochangeactive = 1;
            }
            m+=1;
        })
        if (i != (qu_ids.length - 1)) 
        {
            console.log(i);
            sample(1,i);
        }
    })
}
var qu_ids = [];

$(document).ready(function () {
    $("#mcq").click(function () {
        var vall = $("#mcq").val();
        nochangeactive = 0;
        kk = 0;
        showww(0);
        $.ajax({
            url: 'helper1',
            method: 'post',
            data: 'mcq=' + vall
        }).done(function (ques) {
            //console.log(ques);
            ques = JSON.parse(ques);
            var i =0;
            ques.forEach(function(q){
                qu_ids[i] = q.question_id;
                i++;
            })
            p_mcq_q(0);
            change = 0;
        })
    })
})





/*var ques_no,kk = 0,samp;
$(document).ready(function () {
    $("#mcq").click(function () {
        var vall = $("#mcq").val();
        nochangeactive = 0;
        kk = 0;
        showww(0);
        $.ajax({
            url: 'helper1',
            method: 'post',
            data: 'mcq=' + vall
        }).done(function (ques) {
            console.log(ques);
            ques = JSON.parse(ques);
            ques_no = 1;
            $('#show_all').empty();
            nochangeactive = 0;
            ques.forEach(function (clss) {
                $.ajax({
                    url: 'helper1',
                    method: 'post',
                    data: 'q_id=' + clss.question_id
                }).done(function (ans) {
                    console.log(ans);
                    ans = JSON.parse(ans);
                    if (clss.uplo_ques_type == "img") {
                        var sho = "<br><img src='" + clss.question + "' width='200px' height='200px' style='pointer-events:none'><br>"
                    } else if(clss.uplo_ques_type == "eqn"){
                        var sho = "<br><span id='print_eqn"+ques_no+"'></span>";
                        document.getElementById('only_print').value = clss.question;
                        $('#only_p_but').attr("value","print_eqn"+ques_no);
                        kk =1;
                    }else
                    {
                        var sho = clss.question;
                    }
                    $('#show_all').append('<tr><td>Question.Id : ' + clss.question_id + '</td></tr><tr><td>(' + ques_no + ')</td></tr><tr><td>Question : ' + sho + '</td></tr><tr><td>Answer : ')
                    if(kk == 1)
                    {
                        document.getElementById('only_p_but').click();
                    }
                    ques_no += 1;
                    samp = 1;
                    ans.forEach(function (anss) {
                        if (anss.correct_flag == "crt") {
                            var sym = "✔";
                        } else {
                            var sym = "✖";
                        }
                        if(clss.uplo_ques_type == "eqn")
                        {
                            var oopt = "<span id='print_opt"+clss.question_id+samp+"'></span>";
                            document.getElementById('eqn_print_opt').value = anss.options;
                            $('#opt_p_but').attr("value","print_opt"+clss.question_id+samp);
                        }else
                        {
                            var oopt = anss.options;
                        }
                        $('#show_all').append('option ' + anss.option_id + ' : ' + oopt + '  ' + sym + '<br>')
                        if(kk == 1)
                        {
                            document.getElementById('opt_p_but').click();
                            samp +=1;
                        }
                    })
                    samp = 1;
                    if(clss.uplo_ques_type == "eqn")
                    {
                        var expp = "<span id='print_exp"+clss.question_id+samp+"'></span>";
                        document.getElementById('eqn_print_exp').value = clss.explanation;
                        $('#exp_p_but').attr("value","print_exp"+clss.question_id+samp);
                    }else
                    {
                        var expp = clss.explanation;
                    }
                    $('#show_all').append('</td></tr><tr><td>Explanation : ' + expp + '</td></tr><tr><td>Status : <select name="' + clss.question_id + '" id="fstat" onchange="chcolo(this,1)"><option value="approved" style="color: green;">Approved</option><option value="pending" style="color: red;">Pending</option><option value="rework" style="color: blue;">Rework</option></select></td></tr><tr style="border-bottom: 2px solid black;"><td align="center"><button type="button" onclick="editmode1(' + clss.question_id + ')">Edit</button>&emsp;<button type="button" onclick="deleteques(' + clss.question_id + ')">Delete</button></td></tr>')
                    if(kk == 1)
                    {
                        document.getElementById('exp_p_but').click();
                        samp +=1;
                    }
                    nochangeactive = 0;
                    var stst = clss.ques_status;
                    $('select[name="' + clss.question_id + '"]').val(stst).change();
                    nochangeactive = 1;
                })
            })
        })
        change = 0;
    })
})*/
$(document).ready(function () {
    $("#fib").click(function () {
        showww(0);
        var vall = $("#fib").val();
        nochangeactive = 0;
        $.ajax({
            url: 'helper1',
            method: 'post',
            data: 'fib=' + vall
        }).done(function (ques) 
        {
            console.log(ques);
            ques = JSON.parse(ques);
            ques_no = 1;
            $('#show_all').empty();
            ques.forEach(function (clss) {
                $.ajax({
                    url: 'helper1',
                    method: 'post',
                    data: 'q_id=' + clss.question_id
                }).done(function (ans) {
                    console.log(ans);
                    ans = JSON.parse(ans);
                    if (clss.uplo_ques_type == "img") {
                        var sho = "<br><img src='" + clss.question + "' width='200px' height='200px' style='pointer-events:none'><br>"
                    } else {
                        var sho = clss.question;
                    }
                    $('#show_all').append('<tr><td>Question.Id : ' + clss.question_id + '</td></tr><tr><td>(' + ques_no + ')</td></tr><tr><td>Question : ' + sho + '</td></tr>')
                    ques_no += 1;
                    ans.forEach(function (anss) {
                        $('#show_all').append('<tr><td>Answer : ' + anss.options + '</td></tr>')
                    })
                    $('#show_all').append('<tr><td>Explanation : ' + clss.explanation + '</td></tr><tr><td>Status : <select name="' + clss.question_id + '" id="fstat" onchange="chcolo(this,2)"><option value="approved" style="color: green;">Approved</option><option value="pending" style="color: red;">Pending</option><option value="rework" style="color: blue;">Rework</option></select></td></tr><tr style="border-bottom: 2px solid black;"><td align="center"><button type="button" onclick="editmode2(' + clss.question_id + ')">Edit</button></button>&emsp;<button type="button" onclick="deleteques(' + clss.question_id + ')">Delete</button></td></tr>')
                    nochangeactive = 0;
                    var stst = clss.ques_status;
                    $('select[name="' + clss.question_id + '"]').val(stst).change();
                    nochangeactive = 2;
                })
            })
        })
        change = 0;
    })
})

//show ans
function chcolo(i,ii)
{
    if(i.value == "approved")
        i.style.color="green";
    else if(i.value == "pending")
        i.style.color="red";
    else
        i.style.color="blue";
    if(nochangeactive == 1 && ii == 1)
    {
        var val1 = i.value;
        var val2 = i.name;
        $.ajax({
            url: 'helper1',
            method: 'post',
            data: {stat:val1,id:val2}
        }).done(alert('successfully Updated'))
    }
    if(nochangeactive == 2 && ii == 2)
    {
        var val1 = i.value;
        var val2 = i.name;
        $.ajax({
            url: 'helper1',
            method: 'post',
            data: {stat:val1,id:val2}
        }).done(alert('successfully Updated'))
    }
}
function clo()
{
    document.body.style.overflow='scroll';
    document.getElementById('openmcq').style.display="none";
    document.getElementById('openfillups').style.display="none";
    for(var somm=0;somm<8;somm++)
    {
        if(rr>2)
        {
            remopt();
            $('#choice'+rrr).attr('checked', false);
        }
    }
}
var rrr = 1;
function editmode1(qq)
{
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0,350);
    rrr=1;
    document.getElementById('openmcq').style.display="block";
    document.body.style.overflow='hidden';
    $.ajax({
        url: 'helper1',
        method: 'post',
        data: "mcq1="+qq
    }).done(function(ffques){
        console.log(ffques);
        ffques = JSON.parse(ffques);
        resetform();
        ffques.forEach(function(ffquess){
            $.ajax({
                url: 'helper1',
                method: 'post',
                data: 'q_id='+qq
            }).done(function(ans)
            {
                console.log(ans);
                ans = JSON.parse(ans);
                if(ffquess.uplo_ques_type == "img")
                    {
                        $('#taa').attr("placeholder","Image Question");
                        $('#taa').prop("disabled",true);
                        $('#img').attr("src",ffquess.question);
                        $('#defa1').attr("value",ffquess.question);
                        $('#img_path').attr("placeholder","Server : Learn Basics");
                        $('#isequation1').attr('checked',false);
                        boo = 1;
                        openeqbut('eqbut1','view1','taa','eqs1','mcq',0);
                    }else if(ffquess.uplo_ques_type == "eqn")
                    {
                        $('#taa').prop("disabled",false);
                        $('#img').attr("src","../images/data_entry3.png");
                        $('#img_path').attr("placeholder","Select File!!!!");
                        $('#taa').val(ffquess.question);
                        $('#isequation1').attr('checked',true);
                        boo = 0;
                        openeqbut('eqbut1','view1','taa','eqs1','mcq',1);
                    }else
                    {
                        $('#taa').prop("disabled",false);
                        $('#img').attr("src","../images/data_entry3.png");
                        $('#img_path').attr("placeholder","Select File!!!!");
                        $('#taa').val(ffquess.question)
                        $('#isequation1').attr('checked',false);
                        boo = 1;
                        openeqbut('eqbut1','view1','taa','eqs1','mcq',0);
                    }
                $('#mquestion_id').val(qq)
                ans.forEach(function(anns)
                {
                    if(rrr > 2)
                    {
                        addopt();
                        $('#option'+rrr).val(anns.options)
                    }else
                    {
                        $('#option'+rrr).val(anns.options)
                    }
                    if(anns.correct_flag == "crt")
                    {
                        $('#choice'+rrr).attr('checked', true);
                    }else{
                        $('#choice'+rrr).attr('checked', false);
                    }
                    rrr+=1;
                })
                nochangeactive = 0;
                $('#mstatus').val(ffquess.ques_status).change();
                nochangeactive = 1;
                $('#mexplanation').val(ffquess.explanation)
            })
        })
    })
}
function editmode2(qq)
{
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0,350);
    
    document.getElementById('openfillups').style.display="block";
    document.body.style.overflow='hidden';
    $.ajax({
        url: 'helper1',
        method: 'post',
        data: "fib1="+qq
    }).done(function(ffques){
        console.log(ffques);
        ffques = JSON.parse(ffques);
        resetform();
        ffques.forEach(function(ffquess){
            $.ajax({
                url: 'helper1',
                method: 'post',
                data: 'q_id='+qq
            }).done(function(ans){
                console.log(ans);
                ans = JSON.parse(ans);
                ans.forEach(function(anns){
                    if(ffquess.uplo_ques_type == "img")
                    {
                        $('#taa2').attr("placeholder","Image Question");
                        $('#taa2').prop("disabled",true);
                        $('#img2').attr("src",ffquess.question);
                        $('#defa2').attr("value",ffquess.question);
                        $('#path_img_fib').attr("placeholder","Server : Learn Basics");
                        $('#isequation2').attr('checked',false);
                        boo = 1;
                        openeqbut('eqbut2','view2','taa2','eqs2','fib',0);
                    }else if(ffquess.uplo_ques_type == "eqn")
                    {
                        $('#taa2').prop("disabled",false);
                        $('#img2').attr("src","../images/data_entry3.png");
                        $('#img_path_fib').attr("placeholder","Select File!!!!");
                        $('#taa2').val(ffquess.question);
                        $('#isequation2').attr('checked',true);
                        boo = 0;
                        openeqbut('eqbut2','view2','taa2','eqs2','fib',1);
                    }else
                    {
                        $('#taa2').prop("disabled",false);
                        $('#img2').attr("src","../images/data_entry3.png");
                        $('#path_img_fib').attr("placeholder","Select File!!!!");
                        $('#taa2').val(ffquess.question)
                        $('#isequation2').attr('checked',false);
                        boo = 1;
                        openeqbut('eqbut2','view2','taa2','eqs2','fib',0);
                    }
                    $('#fanswer').val(anns.options)
                    $('#fquestion_id').val(qq)
                    nochangeactive = 0;
                    $('#fstatus').val(ffquess.ques_status).change();
                    nochangeactive = 2;
                    $('#fexplanation').val(ffquess.explanation);
                })
            })
        })
    })
}
function deleteques(qqq)
{
    var su = confirm('Are you sure you want to delete question of question ID : '+qqq+' ?');
    if(su == true)
    {
        $.ajax({
            url: 'helper1',
            method: 'post',
            data: "del1="+qd
        }).done(function(){
            alert("Question ID : "+qqq+" Deleted Successfully");
        })
    }else
    {
        alert('Deletion Aborted');
    }
}

//Image Questions
$(document).ready(function(){
    $(".ques_img").change(function(){
         var fullPath = document.querySelector('.ques_img').value;
         if (fullPath) {
             var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
             var filename = fullPath.substring(startIndex);
             if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                 filename = filename.substring(1);
             }
             document.getElementById('img_path').placeholder = filename;
         }
         

         const file = this.files[0];
         if(file){
            const reader = new FileReader();

            reader.addEventListener("load",function(){
                console.log(this);
                $("#img").attr("src",this.result);
            })      
            
            reader.readAsDataURL(file);
         }
         var k = document.querySelector(".ques_img");
         if(k.files.length == 0)
         {
             null;
         }else
         {
             document.getElementById('taa').value = "Image Question";
             document.getElementById('taa').disabled = true;
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
     /*$.ajax({
         url: 'img_helper',
         method: 'post',
         data: 'del="del"'
     }).done(function(rr){
         alert(rr);
     })*/
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
         const file = this.files[0];
         if(file){
            const reader = new FileReader();

            reader.addEventListener("load",function(){
                console.log(this);
                $("#img2").attr("src",this.result);
            })      
            
            reader.readAsDataURL(file);
         }
         var k = document.querySelector("#ques_img_fib");
         if(k.files.length == 0)
         {
             null;
         }else
         {
             document.getElementById('taa2').value = "Image Question";
             document.getElementById('taa2').disabled = true;
         }
     })
})
function delimg2()
{
    alert("Del");
    document.getElementById("path_img_fib").placeholder = "Select File !!!!";
     document.getElementById('taa2').value = "";
     document.getElementById('taa2').placeholder = "Enter Questions....";
     document.querySelector("#ques_img_fib").value = null;
     document.getElementById('taa2').disabled = false;
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
function openeqbut(id1,id2,id3,id4,type,mm)
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
        if(mm)
            document.getElementById(id3).value = "";
        document.getElementById(id4).style.display="none";
        document.getElementById('renopt').style.display="none";
        document.getElementById('renopt2').style.display="none";
        if(type == "mcq")
        {
            for(var i=1;i<=rr;i++)
            {
                if(mm)
                    document.getElementById('option'+i).value = "";
                document.getElementById('eopt'+i).innerHTML = "";
            }
        }else
        {
            if(mm)
                document.getElementById('fanswer').value = "";
            document.getElementById('fib_show_eqn_ans').innerHTML = "";
        }
        boo = 0;
    }
}