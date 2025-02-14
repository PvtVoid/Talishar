<?php


  function TCCHitEffect($cardID)
  {
    global $mainPlayer, $defPlayer, $combatChainState, $CCS_GoesWhereAfterLinkResolves;
    switch($cardID)
    {
      case "TCC088":
        if(ComboActive()) DamageTrigger($defPlayer, damage:1, type:"DAMAGE", source:$cardID);
        break;
      case "TCC016":
        $combatChainState[$CCS_GoesWhereAfterLinkResolves] = "BOTDECK";
        break;
      case "TCC083":
        AddCurrentTurnEffectFromCombat($cardID, $mainPlayer);
        break;
      default: break;
    }
  }

  function EVOHitEffect($cardID)
  {
    global $mainPlayer, $defPlayer, $combatChainState, $CCS_GoesWhereAfterLinkResolves;
    switch($cardID)
    {
      case "EVO006":
        if(IsHeroAttackTarget()) {
          AddDecisionQueue("MULTIZONEINDICES", $mainPlayer, "MYITEMS:hasCrank=true");
          AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose a card with Crank to get a steam counter", 1);
          AddDecisionQueue("CHOOSEMULTIZONE", $mainPlayer, "<-", 1);
          AddDecisionQueue("MZADDSTEAMCOUNTER", $mainPlayer, "-", 1);
        }
        break;
      case "EVO055":
        if(IsHeroAttackTarget() && EvoUpgradeAmount($mainPlayer) >= 1) PummelHit();
        break;
      case "EVO056":
        if(IsHeroAttackTarget() && EvoUpgradeAmount($mainPlayer) >= 1) DestroyArsenal($defPlayer);
        break;
      case "EVO138":
        if(IsHeroAttackTarget())
        {
          AddDecisionQueue("MULTIZONEINDICES", $mainPlayer, "MYBANISH:maxCost=1;subtype=Item&THEIRBANISH:maxCost=1;subtype=Item");
          AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose an item to put into play");
          AddDecisionQueue("MAYCHOOSEMULTIZONE", $mainPlayer, "<-", 1);
          AddDecisionQueue("MZREMOVE", $mainPlayer, "-", 1);
          AddDecisionQueue("PUTPLAY", $mainPlayer, "0", 1);
        }
        break;
      case "EVO150": case "EVO151": case "EVO152":
        AddDecisionQueue("MULTIZONEINDICES", $mainPlayer, "THEIRITEMS:hasSteamCounter=true&THEIRCHAR:hasSteamCounter=true");
        AddDecisionQueue("SETDQCONTEXT", $mainPlayer, "Choose an equipment, item, or weapon. Remove all steam counters from it.");
        AddDecisionQueue("CHOOSEMULTIZONE", $mainPlayer, "<-", 1);
        AddDecisionQueue("MZREMOVESTEAMCOUNTER", $mainPlayer, "-", 1);
        break;
      case "EVO186": case "EVO187": case "EVO188":
      case "EVO189": case "EVO190": case "EVO191":
        PlayerOpt($mainPlayer, 1);
        break;
      case "EVO198": case "EVO199": case "EVO200":
      case "EVO201": case "EVO202": case "EVO203":
        MZMoveCard($mainPlayer, "MYHAND:subtype=Item;maxCost=1", "", may:true);
        AddDecisionQueue("PUTPLAY", $mainPlayer, "0", 1);
        break;
      case "EVO216": case "EVO217": case "EVO218":
        $combatChainState[$CCS_GoesWhereAfterLinkResolves] = "BOTDECK";
        break;
      case "EVO236":
        if(IsHeroAttackTarget()) {
          $deck = new Deck($defPlayer);
          if($deck->Empty()) { WriteLog("The opponent deck is already... depleted."); break; }
          $deck->BanishTop(banishedBy:$mainPlayer);
        }
        $options = GetChainLinkCards($defPlayer, "", "C");
        AddDecisionQueue("MAYCHOOSECOMBATCHAIN", $mainPlayer, $options);
        AddDecisionQueue("REMOVECOMBATCHAIN", $mainPlayer, "-", 1);
        AddDecisionQueue("MULTIBANISH", $defPlayer, "CC,-,EVO236", 1);
        break;
      case "EVO241":
        PlayAura("DTD232", $defPlayer);
        PlayAura("WTR225", $defPlayer);
        break;
      default: break;
    }
  }

?>
