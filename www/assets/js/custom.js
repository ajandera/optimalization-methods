$(document).ready(function() {
    // add reactants
    $(document).on('click', '#addRactant', function() {
        var row = '<tr><td><label for="mol1">Počet molov</label><input name="reactants_mol[]" type="text" id="mol1" value="" class="form-control"></td><td><label for="h1">Reakčné teplo H</label><input name="reactants_h[]" type="text" id="h1" value="" class="form-control"></td><td><label>&nbsp;</label><div class="btn btn-sm btn-danger remove">x</div></td></tr>';
        $('#reactantTable tr:last').after(row);
    });

    // add products
    $(document).on('click', '#addProduct', function() {
        var row = '<tr><td><label for="mol1">Počet molov</label><input name="products_mol[]" type="text" id="mol1" value="" class="form-control"></td><td><label for="h1">Reakčné teplo H</label><input name="products_h[]" type="text" id="h1" value="" class="form-control"></td><td><label>&nbsp;</label><div class="btn btn-sm btn-danger remove">x</div></td></tr>';
        $('#productsTable tr:last').after(row);
    });

    $(document).on('click', '.remove', function() {
        $(this).parent().parent().remove();
    });

    $("#computation").on("submit", function(event) {
        event.preventDefault();
        var reactantsMol = [];
        var productsMol = [];
        var reactantsH = [];
        var productsH = [];

        $(this).find("[name='reactants_mol[]']").map(function(){
            reactantsMol.push($(this).val());
        }).get();

        $(this).find("[name='products_mol[]']").map(function(){
            productsMol.push($(this).val());
        }).get();

        $(this).find("[name='reactants_h[]']").map(function(){
            reactantsH.push($(this).val());
        }).get();

        $(this).find("[name='products_h[]']").map(function(){
            productsH.push($(this).val());
        }).get();

        //calculate results for 298K
        var reactantsSum = 0;
        var productsSum  = 0;
        for (var i=0;i < reactantsMol.length;i++) {
            reactantsSum += parseFloat(reactantsMol[i])*parseFloat(reactantsH[i]);
        }

        for (var j=0;j < productsMol.length;j++) {
            productsSum += parseFloat(productsMol[j]) * parseFloat(productsH[j]);
        }

        var H298 = parseFloat(productsSum) - parseFloat(reactantsSum);
        var result298 = "";
        if (H298 < 0) {
            result298 = "Reakcia je pri danej teplote exotermická, teplo sa pri nej uvoľňuje.";
        } else {
            result298 = "Reakcia je pri danej teplote endotermická, teplo sa pri nej spotrebuje.";
        }

        var result = "<hr><p>Reakčné teplo pri teplote 298 K: "+H298+" (J.mol<sup>-1</sup>)<br><p>"+result298+"</p>";
        $("#results").html(result);
    });
});