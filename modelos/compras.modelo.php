<?php
include_once "conexion.php";
class ModeloCompras
{
    public static function mdlIngresarCompra($tablaCompra, $datosCompra, $items)
{
    $pdo = Conexion::conectar();
    try {
        $pdo->beginTransaction();
        $fecha = new DateTime("now", new DateTimeZone("America/Bogota")); // GMT-5
        $datosCompra["fechaCreacion"] = $fecha->format("Y-m-d H:i:s");
        // Inserta la compra (sin el campo comTotal por ahora)
        $stmtCompra = $pdo->prepare("INSERT INTO $tablaCompra (comIdProveedor, comNombreProveedor, comCreacion) VALUES (:idProveedor, :nombreProveedor, :fechaCreacion)");
        $stmtCompra->bindParam(":idProveedor", $datosCompra["idProveedor"], PDO::PARAM_INT);
        $stmtCompra->bindParam(":nombreProveedor", $datosCompra["nombreProveedor"], PDO::PARAM_STR);
        $stmtCompra->bindParam(":fechaCreacion", $datosCompra["fechaCreacion"], PDO::PARAM_STR);

        if (!$stmtCompra->execute()) {
            throw new Exception("Error al insertar la compra: " . implode(" | ", $stmtCompra->errorInfo()));
        }

        // Obtiene el ID de la compra recién insertada
        $compraId = $pdo->lastInsertId();

        // Inicializa la variable para acumular el total de la compra
        $totalCompra = 0;

        // Inserta cada ítem en la tabla item_compra
        $stmtItem = $pdo->prepare("INSERT INTO item_compra (itcPrecio, itcDescuento, itcImpuesto, itcCantidad, itcObservaciones, itcSubtotal, comId) VALUES (:precio, :descuento, :impuesto, :cantidad, :observaciones, :subtotal, :comId)");

        // Recorre los arrays de ítems (se asume que tienen la misma longitud)
        $n = count($items["precio"]);
        for ($i = 0; $i < $n; $i++) {
            $precio        = $items["precio"][$i];
            $descuento     = $items["descuento"][$i];
            $impuesto      = $items["impuesto"][$i];
            $cantidad      = $items["cantidad"][$i];
            $observaciones = $items["observaciones"][$i];
            $subtotal      = $items["total"][$i];  

            // Acumula el subtotal en la variable totalCompra
            $totalCompra += intval($subtotal);

            $stmtItem->bindParam(":precio", $precio, PDO::PARAM_STR);
            $stmtItem->bindParam(":descuento", $descuento, PDO::PARAM_STR);
            $stmtItem->bindParam(":impuesto", $impuesto, PDO::PARAM_STR);
            $stmtItem->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
            $stmtItem->bindParam(":observaciones", $observaciones, PDO::PARAM_STR);
            $stmtItem->bindParam(":subtotal", $subtotal, PDO::PARAM_STR);
            $stmtItem->bindParam(":comId", $compraId, PDO::PARAM_INT);

            if (!$stmtItem->execute()) {
                $errorInfo = $stmtItem->errorInfo();
                throw new Exception("Error al insertar un ítem de compra: " . implode(" | ", $errorInfo));
            }
        }

        // Actualiza la compra con el total calculado
        $stmtUpdate = $pdo->prepare("UPDATE $tablaCompra SET comTotal = :total WHERE comId = :compraId");
        $stmtUpdate->bindParam(":total", $totalCompra, PDO::PARAM_STR);
        $stmtUpdate->bindParam(":compraId", $compraId, PDO::PARAM_INT);
        if (!$stmtUpdate->execute()) {
            $errorInfo = $stmtUpdate->errorInfo();
            throw new Exception("Error al actualizar el total de la compra: " . implode(" | ", $errorInfo));
        }

        $pdo->commit();
        return "verdadero";
    } catch (Exception $e) {
        $pdo->rollBack();
        // Opcional: puedes registrar el error o mostrarlo para depuración
        // error_log("Error en mdlIngresarCompra: " . $e->getMessage());
        return "falso";
    }
}


    // Método para mostrar las compras en la tabla principal
    public static function mdlMostrarCompras($tabla)
    {
        $stmt = Conexion::conectar()->prepare("SELECT comId,
         c.comIdProveedor,
         CONCAT(p.cliPrimerNombre, ' ', p.cliSegundoNombre, ' ', p.cliPrimerApellido, ' ', p.cliSegundoApellido) as comNombreProveedor,
         c.comCreacion,
         comTotal
        FROM $tabla c INNER JOIN proveedor p ON c.comIdProveedor = p.cliId
         ORDER BY comId DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
