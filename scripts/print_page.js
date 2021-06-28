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

change = 0;

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
            showww(1);
            $.ajax({
                url: 'helper3',
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
            showww(1);
            $.ajax({
                url: 'helper3',
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
            showww(1);
            $.ajax({
                url: 'helper3',
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
        showww(1);
        $.ajax({
            url: 'helper3',
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
        showww(1);
        $.ajax({
            url: 'helper3',
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
            }
        })
        }
        if(k == 5)
        {
        //6
        document.getElementById('nothing').style.display="block";
        document.getElementById('openshowall').style.display="none";
        document.getElementById('fib').checked=false;
        document.getElementById('mcq').checked=false;
        var conc = $("#loadconc").val();
        $.ajax({
            url: 'helper3',
            method: 'post',
            data: 'conc='+conc
        })
        if(change == 1)
        {
            document.getElementById(variables[6]).click();
        }
        }
    }
}

function showww(i)
{
    if(i == 0)
    {
        document.getElementById('nothing').style.display="none";
        document.getElementById('openshowall').style.display="block";
    }else
    {
        document.getElementById('nothing').style.display="block";
        document.getElementById('fib').disabled=true;
        document.getElementById('mcq').disabled=true;
        document.getElementById('openshowall').style.display="none";
    }
}
var insert;
var q_no;
$(document).ready(function(){
    $("#mcq").click(function(){
        var vall = $("#mcq").val();
        showww(0);
        $.ajax({
            url: 'helper3',
            method: 'post',
            data: 'mcq='+vall
        }).done(function(ques){
            console.log(ques);
            ques = JSON.parse(ques);
            var q_id22 = [],i=0,ii=0;
            ques.forEach(function(iii){
                q_id22[i] = iii.question_id;
                i++;
            });
            $('#show_all').empty();
            if(ques.length == 0)
            {
                $('#show_all').append('<tr><td align="center">No Approved Questions !!!</td></tr>');   
                return 0;
            }
            $('#show_all').append('<tr style="border-bottom: 2px solid black;"><td align="center"><button type="button" onclick="printpdf()">Download as DOC<img src="../images/doc.png" id="imado"></button><br></td></tr>');
            insert = "";
            q_no = 1;
            ques.forEach(function(clss){
                $.ajax({
                    url: 'helper3',
                    method: 'post',
                    data: 'q_id='+q_id22[ii]
                }).done(function(ans){
                    console.log(ans);
                    ans = JSON.parse(ans);
                    if(clss.uplo_ques_type == "img")
                    {
                        var sho = "<img src='"+clss.question+"' width='200px' height='200px' style='pointer-events:none'><br>"
                        var path = q_no+")<br><img src='http://"+ser+"/Project_1/"+clss.question.replace("../","")+"' width='200px' height='200px'><br>"
                    }else
                    {
                        var sho = clss.question.replace(/[\n]/g, "&emsp;");
                        var path = q_no+")<br><span style='color:red;'>"+clss.question.replace("\n","<br>&emsp;")+"</span>";
                    }
                    if(ans != undefined)
                    {
                        $('#show_all').append('<tr><td>Question-ID : '+clss.question_id+'</td></tr><tr><td>('+q_no+')<br>Question : <br>&emsp;<span  style="color:red;">'+sho+'</span></td></tr><tr><td>Answer : ');
                        insert = insert + path+"<br>Answers : ";
                        q_no+=1;
                        ans.forEach(function(anss){
                            if(anss.correct_flag == "crt")
                            {
                                var sym = "<b>";
                                var sym2 = "</b>";
                            }else
                            {
                                var sym = "";
                                var sym2 = "";
                            }
                            $('#show_all').append(sym+'option '+anss.option_id+' : '+anss.options+sym2+'<br>');
                            insert = insert + "<br>&emsp;&emsp;Option "+anss.option_id+" : "+sym+anss.options+sym2; 
                        })
                        $('#show_all').append('</td></tr><tr style="border-bottom: 2px solid black;"><td><u>Explanation :</u> <br>&emsp;'+clss.explanation.replace(/[\n]/g, "&emsp;")+'</td></tr>');
                        insert = insert + "<br>Explanation : <br>&emsp;&emsp;"+clss.explanation.replace("\n", "<br>&emsp;")+"<br><br>";
                    }
                })
                ii++;
            })
        })
        change = 0;
    })
})
$(document).ready(function(){
    $("#fib").click(function(){
        showww(0);
        var vall = $("#fib").val();
        insert = "";
        q_no = 1;
        $.ajax({
            url: 'helper3',
            method: 'post',
            data: 'fib='+vall
        }).done(function(ques){
            console.log(ques);
            ques = JSON.parse(ques);
            var q_id22 = [],i=0,ii=0;
            ques.forEach(function(iii){
                q_id22[i] = iii.question_id;
                i++;
            });
            $('#show_all').empty();
            if(ques.length == 0)
            {
                $('#show_all').append('<tr><td align="center">No Approved Questions !!!</td></tr>');   
                return 0;
            }
            $('#show_all').append('<tr style="border-bottom: 2px solid black;"><td align="center"><button type="button" onclick="printpdf()">Download as DOC<img src="../images/doc.png" id="imado"></button><br></td></tr>');
            ques.forEach(function(clss){
                $.ajax({
                    url: 'helper3',
                    method: 'post',
                    data: 'q_id='+q_id22[ii]
                }).done(function(ans){
                    console.log(ans);
                    ans = JSON.parse(ans);
                    if(clss.uplo_ques_type == "img")
                    {
                        var sho = "<img src='"+clss.question+"' width='200px' height='200px' style='pointer-events:none'><br>"
                        var path = q_no+")<br><img src='http://"+ser+"/Project_1/"+clss.question.replace("../","")+"' width='200px' height='200px'><br>"
                    }else
                    {
                        var sho = clss.question.replace(/[\n]/g, "&emsp;");
                        var path = q_no+")<br><span style='color:red;'>"+clss.question.replace("\n","<br>&emsp;")+"</span>";
                    }
                    if(ans != undefined)
                    {
                        $('#show_all').append('<tr><td>Question-ID : '+clss.question_id+'</td></tr><tr><td>('+q_no+')<br>Question : <br>&emsp;<span  style="color:red;">'+sho+'</span></td></tr>')
                        q_no+=1;
                        insert = insert + path+"<br>Answer : ";
                        ans.forEach(function(anss){
                            $('#show_all').append('<tr><td style="font-weight:600;">Answer : '+anss.options+'</td></tr>')
                            insert = insert + "&emsp;<b>"+anss.options+"</b><br>";
                        })
                        $('#show_all').append('<tr style="border-bottom: 2px solid black;"><td><u>Explanation :</u> <br>&emsp;'+clss.explanation.replace(/[\n]/g, "<br>&emsp;")+'</td></tr>')
                        insert = insert + "<br>Explanation : <br>&emsp;&emsp;"+clss.explanation.replace("\n", "<br>&emsp;")+"<br><br>";
                    }
                })
                ii++;
            })
        })
        change = 0;
    })
})

function exportHTML(filename)
{
    var header1 = "<html xmlns:o='urn:schemas-microsoft-com:office:office' " + "xmlns:w='urn:schemas-microsoft-com:office:word' " + "xmlns='http://www.w3.org/TR/REC-html40'>" + "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title></head><body>";
    var footer1 = "</body></html>";
    var sourceHTML = header1 + insert + footer1;
    var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
    var fileDownload = document.createElement("a");
    document.body.appendChild(fileDownload);
    fileDownload.href = source;
    fileDownload.download = filename;
    fileDownload.click();
    document.body.removeChild(fileDownload);
}