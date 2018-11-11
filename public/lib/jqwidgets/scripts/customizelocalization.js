/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
﻿var getLocalization = function (culture) {
    var localization = null;
    switch (culture) {
              case "en":
                case "sl":
            localization =
             {
     
                 percentsymbol: "%",
                 currencysymbol: " ",
                 currencysymbolposition: "before",
                 decimalseparator: '.',
                 thousandsseparator: ','

             }
            break;
        default:
            break;
    }
    return localization;
}

