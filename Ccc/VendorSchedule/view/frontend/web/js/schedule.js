/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
        function showUser(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else { 
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("POST","<?php echo $this->getUrl().'news/index/index'?>",true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send(str);
            }
        }
        
        var year;
        var month;
        var day;
        var week;

        function getCurrentDay(){
            var today = new Date();
            day = today.getDate();
            month = today.getMonth()+1;
            year = today.getFullYear();
            week = today.getDay();
        }

        function getWeekOfDay(){
            var title;
            switch(week){
                case 2: title = "Monday";
                    break;
                case 3: title = "Tuesday";
                    break;
                case 4: title = "Wednesday";
                    break;
                case 5: title = "Thrusday";
                    break;
                case 6: title = "Friday";
                    break;
                case 7: title = "Saturday";
                    break;
                case 1: title = "Sunday";
                    break;
            }
            return title;
        }

        function getMonthDays(month){
            switch(month){
                case 1:
                case 3:
                case 5:
                case 7:
                case 8:
                case 10:
                case 12:
                    return 31;
                case 4:
                case 6:
                case 9:
                case 11:
                    return 30;
                case 2:
                    if(year % 400 === 0 || (year % 4 === 0 && year % 100 !== 0)){
                        return 29;
                    }else{
                        return 28;
                    }
            }
        }

        function getMonthName(month){
            switch(month){
                case 1: return "January";
                case 2: return "February";
                case 3: return "March";
                case 4: return "April";
                case 5: return "May";
                case 6: return "June";
                case 7: return "July";
                case 8: return "August";
                case 9: return "September";
                case 10: return "October";
                case 11: return "November";
                case 12: return "December";
            }
        }

        function createCalendarHeader(){
            var head_row = document.createElement("TR");
            head_row.id = "calendar_table_head_row";
            var table_head = document.createElement("TH");
            table_head.id = "calendar_table_head";
            table_head.innerHTML = "Calendar";
            table_head.style.align = "center";
            head_row.appendChild(table_head);
            return head_row;
        }

        function createYearRow(year){
            var row_year = document.createElement("TR");
            row_year.id = "row_year";
            var th1 = document.createElement("TD");
            var th2 = document.createElement("TD");
            var th3 = document.createElement("TD");
            var year_p = document.createElement("TD");
            year_p.id = "year_p";
            year_p.innerHTML = "previous";
            year_p.onclick = function(){yearChange(-1);};
            var year_n = document.createElement("TD");
            year_n.id = "year_n";
            year_n.innerHTML = "next";
            year_n.onclick = function(){yearChange(1);};
            var year_title = document.createElement("P");
            year_title.id = "year_title";
            year_title.innerHTML = year;
            th1.appendChild(year_p);
            th2.appendChild(year_title);
            th3.appendChild(year_n);
            row_year.appendChild(th1);
            row_year.appendChild(th2);
            row_year.appendChild(th3);
            return row_year;
        }

        function createMonthRow(month){
            var row_month = document.createElement("TR");
            row_month.id = "row_month";
            var m1 = document.createElement("TD");
            var m2 = document.createElement("TD");
            var m3 = document.createElement("TD");
            var month_p = document.createElement("TD");
            month_p.id = "month_p";
            month_p.innerHTML = "previous";
            month_p.onclick = function(){monthChange(-1);};
            var month_n = document.createElement("TD");
            month_n.id = "month_n";
            month_n.innerHTML = "next";
            month_n.onclick = function(){monthChange(1);};
            var month_title = document.createElement("P");
            month_title.id = "month_title";
            month_title.innerHTML = getMonthName(month);
            m1.appendChild(month_p);
            m2.appendChild(month_title);
            m3.appendChild(month_n);
            row_month.appendChild(m1);
            row_month.appendChild(m2);
            row_month.appendChild(m3);
            return row_month;
        }

        function createDayTitle(){
            var day_title = document.createElement("TR"); 
            day_title.id = "day_title_row";
            for(var i = 1; i <= 7; i++){
                var title;
                switch(i){
                    case 2: title = "Monday";
                        break;
                    case 3: title = "Tuesday";
                        break;
                    case 4: title = "Wednesday";
                        break;
                    case 5: title = "Thrusday";
                        break;
                    case 6: title = "Friday";
                        break;
                    case 7: title = "Saturday";
                        break;
                    case 1: title = "Sunday";
                        break;
                }
                var t = document.createElement("TD");
                t.innerHTML = title;
                day_title.appendChild(t);
            }
            return day_title;
        }

        function createWeek(days){
            var week = document.createElement("TR"); 
            week.className = "day_row";
            for(var i = 0; i < days.length; i++){
                var j = days[i];
                var t = document.createElement("TD");

                if(j === 100){
                    t.innerHTML = "_";
                }else{
                    var a = document.createElement("A");
                    t.innerHTML = j.toString();
                    t.className = "day_row_cell";
                    t.appendChild(a);
                    t.id = j;
                    var today = new Date();
                    t.onclick = function(){
                        day = this.id;
                        if(year > today.getFullYear() || (year === today.getFullYear() && month > today.getMonth() + 1) 
                            || (year === today.getFullYear() && month === today.getMonth() + 1 && day >= today.getDate())){
                            this.style.backgroundColor = "lightgrey";
                        }
                        resetCalendar();
                    };
                }
                if(j === day){
                    t.style.backgroundColor = "lightgrey";
                }
                week.appendChild(t);
            }
            return week;
        }

        function createDays(days){
            var days_blank = new Date(year + "-" + month + "-01").getDay();
            //document.getElementById("test").innerHTML = days_blank;
            var table_days = document.createElement("TABLE");
            table_days.id = "calendar_table_days";
            for(var i = 1; i <= days;){
                var k = [];
                for(var j = 0; j < 7; j++){
                    if(days_blank !== 7 && i === 1){
                        for(var n = days_blank; n > 0; n--){
                            k.push(100);
                        }
                        j += days_blank;
                        k.push(i);
                    }else{
                        if(i <= days){
                            k.push(i);
                        }
                    }
                    i++;
                }
                table_days.appendChild(createWeek(k));
            }
            return table_days;
        }

        function yearChange(change){
            year += change;
            resetCalendar();
        }

        function monthChange(change){

            month += change;
            if(month <= 0){
                month += 12;
                year -= 1;
            }else if(month > 12){
                month -= 12;
                year += 1;
            }
            resetCalendar();
        }

        function setBackgroundColor(){
            var background_color;
            switch(month){
                case 1: 
                    background_color = "yellow";
                    break;
                case 2: 
                    background_color = "orange";
                    break;
                case 3: 
                    background_color = "red";
                    break;
                case 4: 
                    background_color = "gold";
                    break;
                case 5: 
                    background_color = "goldenrod";
                    break;
                case 6: 
                    background_color = "darkgoldenrod";
                    break;
                case 7: 
                    background_color = "paleturquoise";
                    break;
                case 8: 
                    background_color = "lightblue";
                    break;
                case 9: 
                    background_color = "lightskyblue";
                    break;
                case 10: 
                    background_color = "lightgreen";
                    break;
                case 11: 
                    background_color = "aquamarine";
                    break;
                case 12: 
                    background_color = "yellowgreen";
                    break;
            }
            document.getElementById("row_year").style.backgroundColor = background_color;
            document.getElementById("row_month").style.backgroundColor = background_color;
            var tables = document.getElementsByTagName("calendar_table");
            for(var i = 0; i < tables.length; i++){
                tables[i].style.borderColorr = background_color;
            }
        document.getElementById("day_detail_info_head").style.backgroundColor = background_color;
        var days = document.getElementsByClassName("day_row_cell");
        days[day - 1].style.backgroundColor = "lightgrey";
    }

    function createDayDetail(){
        var table = document.createElement("TABLE");
        table.id = "day_detail_info";
        var head = document.createElement("TH");
        table.id = "day_detail_info_head";
        var head_row = document.createElement("TR");
        var head_row_cell = document.createElement("TD");
        head_row_cell.innerHTML = day + "/" + month + "/" + year + "  " + getWeekOfDay();
        head_row_cell.style.cssText = "width: 600px; text-align: center;";
        head_row.appendChild(head_row_cell);
        head.appendChild(head_row);
        table.appendChild(head);
        for(var i = 8; i <= 20; i++){
            var info_row = document.createElement("TR");
            var time_cell = document.createElement("TD");
            time_cell.style.cssText = "width: 100px; text-align: center; background-color: white;";
            var availability = document.createElement("TD");
            availability.id = i + "_" + day + "_" + month + "_" + year;
            availability.style.cssText = "width: 550px; text-align: center; background-color: white;";
            var a = document.createElement("A");
            a.style.cssText = "cursor: pointer;";
            //a.innerHTML = "AVAILABLE";
            a.id = i;
            var today = new Date();
            if(year > today.getFullYear() || (year == today.getFullYear() && month > today.getMonth() + 1) 
                    || (year == today.getFullYear() && month == today.getMonth() + 1 && day > today.getDate()) 
                    || (year == today.getFullYear() && month == today.getMonth() + 1 && day == today.getDate() && i > today.getHours())){
                a.innerHTML = "NO BOOKED";
                a.onclick = function(){
                    createAppiontmentArea(this.id);
                };
            }
            time_cell.innerHTML = i + ":00";
            availability.appendChild(a);
            info_row.appendChild(time_cell);
            info_row.appendChild(availability);
            table.appendChild(info_row);
        }
        document.getElementById("day_detail").append(table);
    }

    function createAppiontmentArea(time){
        if(document.getElementById("info_area") !== null){
            document.getElementById("calendar_message").removeChild(document.getElementById("info_area"));
            document.getElementById("calendar_message").removeChild(document.getElementById("info_area_title"));
        }
        var vendor_row = document.createElement("TR");
        var vendor_row_cell1 = document.createElement("TD");
        var vendor_row_cell2 = document.createElement("TD");
        var vendor_row_cell2_content = document.createElement("INPUT");
        vendor_row_cell1.className = "message_title";
        vendor_row_cell2_content.id = "appointment_vendor";
        vendor_row_cell2_content.name = "appointment_vendor";
        vendor_row_cell1.innerHTML = "Vendor: ";
        vendor_row_cell2_content.readOnly = true;
        vendor_row_cell2_content.value = "1";// Waiting for updated
        vendor_row_cell2.appendChild(vendor_row_cell2_content);
        vendor_row.appendChild(vendor_row_cell1);
        vendor_row.appendChild(vendor_row_cell2);
        
        var customer_row = document.createElement("TR");
        var customer_row_cell1 = document.createElement("TD");
        var customer_row_cell2 = document.createElement("TD");
        var customer_row_cell2_content = document.createElement("INPUT");
        customer_row_cell1.className = "message_title";
        customer_row_cell2_content.id = "appointment_customer";
        customer_row_cell2_content.name = "appointment_customer";
        customer_row_cell1.innerHTML = "Customer: ";
        customer_row_cell2_content.readOnly = true;
        customer_row_cell2_content.value = "1";// Waiting for updated
        customer_row_cell2.appendChild(customer_row_cell2_content);
        customer_row.appendChild(customer_row_cell1);
        customer_row.appendChild(customer_row_cell2);
        
        var date_row = document.createElement("TR");
        var date_row_cell1 = document.createElement("TD");
        var date_row_cell2 = document.createElement("TD");
        var date_row_cell2_content = document.createElement("INPUT");
        date_row_cell1.className = "message_title";
        date_row_cell2_content.id = "appointment_date";
        date_row_cell2_content.name = "appointment_date";
        date_row_cell1.innerHTML = "Customer: ";
        date_row_cell2_content.readOnly = true;
        date_row_cell2_content.value = day + "/" + month + "/" + year;
        date_row_cell2.appendChild(date_row_cell2_content);
        date_row.appendChild(date_row_cell1);
        date_row.appendChild(date_row_cell2);
        
        var time_row = document.createElement("TR");
        var time_row_cell1 = document.createElement("TD");
        var time_row_cell2 = document.createElement("TD");
        var time_content = document.createElement("INPUT");
        time_row_cell1.className = "message_title";
        time_content.id = "appointment_time";
        time_content.name = "appointment_time";
        time_row_cell1.innerHTML = "Time: ";
        time_content.readOnly = true;
        time_content.value = time+ ":00";
        time_row_cell2.appendChild(time_content);
        time_row.appendChild(time_row_cell1);
        time_row.appendChild(time_row_cell2);
        
        var address_row = document.createElement("TR");
        var address_row_cell1 = document.createElement("TD");
        var address_row_cell2 = document.createElement("TD");
        address_row_cell1.className = "message_title";
        address_row_cell1.innerHTML = "Address: ";
        address_row_cell1.style.cssText = "width:100px; height:50px;";
        var address_textarea = document.createElement("textarea");
        address_textarea.id = "appointment_address";
        address_textarea.name = "appointment_address";
        address_textarea.style.cssText = "width:600px; height:35px;";
        address_row_cell2.appendChild(address_textarea);
        address_row.appendChild(address_row_cell1);
        address_row.appendChild(address_row_cell2);
        var info_row = document.createElement("TR");
        var text_area = document.createElement("textarea");
        text_area.id = "appointment_content";
        text_area.name = "appointment_content";
        text_area.style.cssText = "width:900px; height:100px;";
        info_row.appendChild(text_area);
        var button_row = document.createElement("TR");
        var send_button = document.createElement("button");
        var cancel_button = document.createElement("button");
        send_button.id = "appointment_add";
        send_button.type = "submit";
        send_button.innerHTML = "ADD";
        cancel_button.innerHTML = "CANCEL";
        cancel_button.onclick = function(){
            document.getElementById("calendar_message").removeChild(document.getElementById("info_area"));
            document.getElementById("calendar_message").removeChild(document.getElementById("info_area_title"));
        };
        button_row.appendChild(send_button);
        button_row.appendChild(cancel_button);
        
        var table = document.createElement("TABLE");
        table.id = "info_area_title";
        table.appendChild(vendor_row);
        table.appendChild(customer_row);
        table.appendChild(date_row);
        table.appendChild(time_row);
        table.appendChild(address_row);
        var table1 = document.createElement("TABLE");
        table1.id = "info_area";
        table1.appendChild(info_row);
        table1.appendChild(button_row);
        document.getElementById("calendar_message").append(table);
        document.getElementById("calendar_message").append(table1);
    }
    
    function createCalendar(){
        getCurrentDay();
        createDayDetail();
        var table = document.createElement("TABLE");
        table.className = "calendar_table";
        table.appendChild(createYearRow(year));
        var table_month = document.createElement("TABLE");
        table_month.className = "calendar_table";
        table_month.appendChild(createMonthRow(month));
        var table_day = document.createElement("TABLE");
        table_day.className = "calendar_table";
        table_day.appendChild(createDayTitle());

        document.getElementById("calendar").append(table);
        document.getElementById("calendar").append(table_month);
        document.getElementById("calendar").append(table_day);
        document.getElementById("calendar").append(createDays(getMonthDays(month)));
        setBackgroundColor();

    }

    function resetCalendar(){
        document.getElementById("calendar").innerHTML = "";
        document.getElementById("day_detail").innerHTML = "";
        createDayDetail();
        var table = document.createElement("TABLE");
        table.className = "calendar_table";
        table.appendChild(createYearRow(year));
        var table_month = document.createElement("TABLE");
        table_month.className = "calendar_table";
        table_month.appendChild(createMonthRow(month));
        var table_day = document.createElement("TABLE");
        table_day.className = "calendar_table";
        table_day.appendChild(createDayTitle());

        document.getElementById("calendar").append(table);
        document.getElementById("calendar").append(table_month);
        document.getElementById("calendar").append(table_day);
        document.getElementById("calendar").append(createDays(getMonthDays(month)));
        setBackgroundColor();
        
        /*if(document.getElementById("appointment_add") != null){
            document.getElementById("appointment_add").onclick = function() {addData();};
        }*/
    }
    
    function getInsertData(){
        var VENDOR_ID = 1;     
        var CUSTOMER_ID = 1;
        var TIME = $("#appointment_time").val();
        var DATE = day + "/" + month + "/" + year;
        var ADDRESS = $("#appointment_address").val();
        var CONTENT = $("#appointment_content").val();
        var STATUS = "vendor unread";
        var myData = new Array();
        myData['vendor_id'] = VENDOR_ID;
        alert(myData['vendor_id']);
        myData['CUSTOMER_ID'] = CUSTOMER_ID;
        myData['TIME'] = TIME;
        myData['DATE'] = DATE;
        myData['ADDRESS'] = ADDRESS;
        myData['CONTENT'] = CONTENT;
        myData['CONTENT'] = CONTENT;
        myData['STATUS'] = STATUS;
        /*var myData={"info":{
                "VENDOR_ID":VENDOR_ID,"CUSTOMER_ID":CUSTOMER_ID,"TIME":TIME,"DATE":DATE,"ADDRESS":ADDRESS,"CONTENT":CONTENT,"STATUS":STATUS
            }
        };*/
        return myData;
    }
    
    function insert(){
        $.post("<?php echo $this->getUrl().'news/index/index'?>", getInsertData(), function(){$("#test").innerHTML = "success";
        });
    }

        function insertData(){
            /*require(["jquery"],function($) {
                $("#calendar_form #appointment_add").click(function(){
                    //get the form values
                    //var ID = $('#ID').val();     
                    var VENDOR_ID = 1;     
                    var CUSTOMER_ID = 1;
                    var TIME = document.getElementById("appointment_time").value;
                    var DATE = day + "/" + month + "/" + year;
                    var ADDRESS = document.getElementById("appointment_address").value;
                    var CONTENT = document.getElementById("appointment_content").value;
                    var STATUS = "vendor unread";
                    // make the postdata
                    // var postData = '&ID='+ID+'&NAME='+NAME+'&PASSWORD='+PASSWORD+'&CREDITS'+CREDITS+'&EMAIL_ID'+EMAIL_ID+'&CREATED_ON'+CREATED_ON+'&MODIFIED_ON'+MODIFIED_ON;
                    // alert(postData);
                    var myData={'VENDOR_ID':VENDOR_ID,CUSTOMER_ID:CUSTOMER_ID,TIME:TIME,DATE:DATE,ADDRESS:ADDRESS,CONTENT:CONTENT,STATUS:STATUS};
                    //call your .php script in the background, 
                    //when it returns it will call the success function if the request was successful or 
                    //the error one if there was an issue (like a 404, 500 or any other error status)
                    var customurl = "<?php echo $this->getUrl().'news/index/index'?>";
                    $.ajax({
                       url: customurl,
                       type: "POST",
                       data : myData,
                       //dataType: 'json',
                       success: function(){
                           document.getElementById('test').innerHTML = "success";
                        }
                    }); 
                }); 
            });*/
            define([
                'jquery',
                'underscore',
                'mage/template',
                'jquery/list-filter'
                ], function (
                    $,
                    _,
                    template
                ) {
                    function main(element) {
                        var $element = $(element);
                        var customurl = "<?php echo $this->getUrl().'news/index/index'?>";
                        $(document).on('click','#calendar_form #appointment_add',function() {
                            var VENDOR_ID = 1;     
                            var CUSTOMER_ID = 1;
                            var TIME = document.getElementById("appointment_time").value;
                            var DATE = day + "/" + month + "/" + year;
                            var ADDRESS = document.getElementById("appointment_address").value;
                            var CONTENT = document.getElementById("appointment_content").value;
                            var STATUS = "vendor unread";
                            var myData={"info":{
                                    "VENDOR_ID":VENDOR_ID,"CUSTOMER_ID":CUSTOMER_ID,"TIME":TIME,"DATE":DATE,"ADDRESS":ADDRESS,"CONTENT":CONTENT,"STATUS":STATUS
                                }
                            };
                            $.ajax({
                                showLoader: true,
                                url: customurl,
                                data: myData,
                                type: "POST",
                                dataType: 'json'
                            }).done(function (data) {
                                //$('#test').removeClass('hideme');
                                var html = template('#test', {posts:data}); 
                                $('#test').html(html);
                            });
                        });
                    };
                    return main;
                });
        }
        createCalendar();



