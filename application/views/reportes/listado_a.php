<table id="myDataTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Zona</th>
            <th>Direccion</th>
            <th>Descripcion</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>


<script type="text/javascript">
$('#myDataTable').dataTable( {
        processing: true,
        serverSide: true,
        ajax: {
            "url": "/reportes/dataTable",
            "type": "POST"
        },
        columns: [
            { data: "r.id" },
            {data : "r.zona_id"},
            {data : "r.direccion"},
            {data : "r.descripcion"}
//            ,
//            { data: "$.city_state_zip" } //refers to the expression in the "More Advanced DatatableModel Implementation"
        ]
    });
</script>