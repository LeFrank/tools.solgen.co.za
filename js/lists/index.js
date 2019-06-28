$(function () {
//        $("#expenseDate").datetimepicker();
//        CKEDITOR.replace('description');
//        $("#expenseType").change(function () {
//            $.post(
//                    "/expense-types/type/" + $(this).val(),
//                    null
//            ).done(function (resp) {
//                obj =  JSON.parse(resp);
//                if(null != obj.template && obj.template != "" ){
//                    CKEDITOR.instances.description.setData(CKEDITOR.instances.description.getData() + obj.template);
//                }
//            });
//        });
        
    });
    function allowDrop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            var ele = this.id; 
            console.log(data);
            console.log(ele);
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev,ele) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            
            ev.target.appendChild(document.getElementById(data));
            console.log($("#" + data).attr("data-order"));
            var id = $(ele)[0].id;
            console.log(id);
            console.log($("#" + id).attr("data-order-val"));
            var v = $("#" + id).attr("data-order-val");
            $("#" + data).attr("data-order", v );
            console.log($("#" + data).attr("data-order"));
        }