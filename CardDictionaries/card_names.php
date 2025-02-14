<?php

function CardName($cardID)
{
    $arr = str_split($cardID, 3);
    if(count($arr) < 2) return "";
    $set = $arr[0];
    if($set != "ROG" && $set != "DUM")
    {
      $number = intval(substr($cardID, 3));
      if($number < 400 || ($set != "MON" && $set != "DYN" && $cardID != "EVO410a" && $cardID != "EVO410b")) return GeneratedCardName($cardID);
    }
    if ($set == "ROG") {
      return ROGUEName($cardID);
    }
    switch($cardID)
    {
		  case "MON400": return "Spell Fray Cloak";
		  case "MON401": return "Spell Fray Gloves";
		  case "MON402": return "Spell Fray Leggings";
		  case "MON404": return "The Librarian";
		  case "MON405": return "Minerva Themis";
		  case "MON406": return "Lady Barthimont";
		  case "MON407": return "Lord Sutcliffe";
      case "DYN492": return "Nitro Mechanoid";
		  case "DYN492a": return "Nitro Mechanoid";
		  case "DYN492b": return "Nitro Mechanoid";
		  case "DYN492c": return "Nitro Mechanoid";
      case "DYN612": return "Suraya, Archangel of Knowledge";
      case "DUMMY": return "Practice Dummy";
      case "DUMMYDISHONORED": return "Dishonored Hero";
      case "EVO410": return "Nitro Mechanoid";
      case "EVO410a": return "Teklovossen, the Mechropotent";
      case "EVO410b": return "Teklovossen, the Mechropotent";
      default: return "";
    }
    return "";
	}
