import {convertLatexToMarkup} from '../lib/mathlive-master/mathlive.min.js';
        document.querySelector('#view2').addEventListener('click', (ev) => {
            var r = document.getElementById('taa2').value;
            if(r.length > 0)
            {
                document.getElementById('eqs2').style.display='block';
            }else
            {
                document.getElementById('eqs2').style.display='none';
            }
            document.getElementById('equation_show2').innerHTML = "";
            var a=0,s;
            var i =0;
            while(i < r.length)
            {
            var rrr = "";
            if(r[i] == "$")
            {
                if(a == 0)
                {
                    a = 1;
                }
            }
            if(a == 0)
            {
                if(r[i] == "\n")
                {
                    s = "<br>";
                }else
                {
                    s="";
                }
                var tex = document.getElementById('equation_show2').innerHTML;
                document.getElementById('equation_show2').innerHTML = tex + r[i] + s; 
                i+=1;
            }else
            {
                var tex = document.getElementById('equation_show2').innerHTML;
                var j=i+1;
                while(1)
                {
                    if(r[j] == "$")
                    {
                        break;
                    }
                    rrr = rrr + r[j];
                    j+=1;
                }
                document.getElementById('equation_show2').innerHTML = tex + convertLatexToMarkup(rrr);
                i=(j+1);
                a=0;
            }
        }
        });
    
    
        
        document.querySelector('#view1').addEventListener('click', (ev) => {
            var r = document.getElementById('taa').value;
            if(r.length > 0)
            {
                document.getElementById('eqs1').style.display='block';
            }else
            {
                document.getElementById('eqs1').style.display='none';
            }
            document.getElementById('equation_show1').innerHTML = "";
            var a=0,s;
            var i =0;
            while(i < r.length)
            {
            var rrr = "";
            if(r[i] == "$")
            {
                if(a == 0)
                {
                    a = 1;
                }
            }
            if(a == 0)
            {
                if(r[i] == "\n")
                {
                    s = "<br>";
                }else
                {
                    s="";
                }
                var tex = document.getElementById('equation_show1').innerHTML;
                document.getElementById('equation_show1').innerHTML = tex + r[i] + s; 
                i+=1;
            }else
            {
                var tex = document.getElementById('equation_show1').innerHTML;
                var j=i+1;
                while(1)
                {
                    if(r[j] == "$")
                    {
                        break;
                    }
                    rrr = rrr + r[j];
                    j+=1;
                }
                document.getElementById('equation_show1').innerHTML = tex + convertLatexToMarkup(rrr);
                i=(j+1);
                a=0;
            }
        }
        });
    
    
        
        document.querySelector('#renopt').addEventListener('click', (ev) => {
            var rr = document.getElementById('submcq').value;
            for(var no=1;no<=rr;no++)
            {
            var r = document.getElementById('option'+no).value;
            if(r == "")
            {
                document.getElementById('eopt'+no).innerHTML = "";
                continue;
            }
            document.getElementById('eopt'+no).innerHTML = "";
            var a=0,s;
            var i =0;
            while(i < r.length)
            {
            var rrr = "";
            if(r[i] == "$")
            {
                if(a == 0)
                {
                    a = 1;
                }
            }
            if(a == 0)
            {
                if(r[i] == "\n")
                {
                    s = "<br>";
                }else
                {
                    s="";
                }
                var tex = document.getElementById('eopt'+no).innerHTML;
                document.getElementById('eopt'+no).innerHTML = tex + r[i] + s; 
                i+=1;
            }else
            {
                var tex = document.getElementById('eopt'+no).innerHTML;
                var j=i+1;
                while(1)
                {
                    if(r[j] == "$")
                    {
                        break;
                    }
                    rrr = rrr + r[j];
                    j+=1;
                }
                document.getElementById('eopt'+no).innerHTML = tex + convertLatexToMarkup(rrr);
                i=(j+1);
                a=0;
            }
        }
    }
        });
    
    
        
        document.querySelector('#renopt2').addEventListener('click', (ev) => {
            var r = document.getElementById('fanswer').value;
            if(r != "")
            {
                document.getElementById('fib_show_eqn_ans').innerHTML = "";
                var a=0,s;
                var i =0;
                while(i < r.length)
                {
                var rrr = "";
                if(r[i] == "$")
                {
                    if(a == 0)
                    {
                        a = 1;
                    }
                }
                if(a == 0)
                {
                    if(r[i] == "\n")
                    {
                        s = "<br>";
                    }else
                    {
                        s="";
                    }
                    var tex = document.getElementById('fib_show_eqn_ans').innerHTML;
                    document.getElementById('fib_show_eqn_ans').innerHTML = tex + r[i] + s; 
                    i+=1;
                }else
                {
                    var tex = document.getElementById('fib_show_eqn_ans').innerHTML;
                    var j=i+1;
                    while(1)
                    {
                        if(r[j] == "$")
                        {
                            break;
                        }
                        rrr = rrr + r[j];
                        j+=1;
                    }
                    document.getElementById('fib_show_eqn_ans').innerHTML = tex + convertLatexToMarkup(rrr);
                    i=(j+1);
                    a=0;
                }
            }
        }
        else
        {
            document.getElementById('fib_show_eqn_ans').innerHTML = "";
        }
    });
    