para optimizar proximo desarrollo

// $trackings = array();
// $total_line_traking = array();
// $clave = array();
// $line_trakins = array();

// foreach ($user_trackins as $user_trackin) {
// $trackings[] = json_decode($user_trackin->description);
// }

// foreach ($trackings as $tracking) {

// foreach ($tracking as $line) {
// $total_line_traking[] = [
// 'action' => $line->action,
// 'value' => $line->value
// ];
// }
// }

// foreach ($total_line_traking as $item) {
// $clave[] = $item['action'];
// }

// $unico = array_unique($clave);

// foreach ($unico as $uni) {
// $suma = 0;

// foreach ($total_line_traking as $original) {
// if ($uni == $original['action']) {
// $suma = $suma + $original['value'];
// }
// }

// array_push($line_trakins, array(
// 'x' => $uni,
// 'value' => $suma
// ));
// }

// return response()->json(['success' => true, 'data' => $user_trackins]);