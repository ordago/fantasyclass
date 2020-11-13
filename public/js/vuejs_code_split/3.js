(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/vfa-picker/dist/vfa-picker.common.js":
/*!***********************************************************!*\
  !*** ./node_modules/vfa-picker/dist/vfa-picker.common.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports =
/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "fb15");
/******/ })
/************************************************************************/
/******/ ({

/***/ "01f9":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var LIBRARY = __webpack_require__("2d00");
var $export = __webpack_require__("5ca1");
var redefine = __webpack_require__("2aba");
var hide = __webpack_require__("32e9");
var Iterators = __webpack_require__("84f2");
var $iterCreate = __webpack_require__("41a0");
var setToStringTag = __webpack_require__("7f20");
var getPrototypeOf = __webpack_require__("38fd");
var ITERATOR = __webpack_require__("2b4c")('iterator');
var BUGGY = !([].keys && 'next' in [].keys()); // Safari has buggy iterators w/o `next`
var FF_ITERATOR = '@@iterator';
var KEYS = 'keys';
var VALUES = 'values';

var returnThis = function () { return this; };

module.exports = function (Base, NAME, Constructor, next, DEFAULT, IS_SET, FORCED) {
  $iterCreate(Constructor, NAME, next);
  var getMethod = function (kind) {
    if (!BUGGY && kind in proto) return proto[kind];
    switch (kind) {
      case KEYS: return function keys() { return new Constructor(this, kind); };
      case VALUES: return function values() { return new Constructor(this, kind); };
    } return function entries() { return new Constructor(this, kind); };
  };
  var TAG = NAME + ' Iterator';
  var DEF_VALUES = DEFAULT == VALUES;
  var VALUES_BUG = false;
  var proto = Base.prototype;
  var $native = proto[ITERATOR] || proto[FF_ITERATOR] || DEFAULT && proto[DEFAULT];
  var $default = $native || getMethod(DEFAULT);
  var $entries = DEFAULT ? !DEF_VALUES ? $default : getMethod('entries') : undefined;
  var $anyNative = NAME == 'Array' ? proto.entries || $native : $native;
  var methods, key, IteratorPrototype;
  // Fix native
  if ($anyNative) {
    IteratorPrototype = getPrototypeOf($anyNative.call(new Base()));
    if (IteratorPrototype !== Object.prototype && IteratorPrototype.next) {
      // Set @@toStringTag to native iterators
      setToStringTag(IteratorPrototype, TAG, true);
      // fix for some old engines
      if (!LIBRARY && typeof IteratorPrototype[ITERATOR] != 'function') hide(IteratorPrototype, ITERATOR, returnThis);
    }
  }
  // fix Array#{values, @@iterator}.name in V8 / FF
  if (DEF_VALUES && $native && $native.name !== VALUES) {
    VALUES_BUG = true;
    $default = function values() { return $native.call(this); };
  }
  // Define iterator
  if ((!LIBRARY || FORCED) && (BUGGY || VALUES_BUG || !proto[ITERATOR])) {
    hide(proto, ITERATOR, $default);
  }
  // Plug for library
  Iterators[NAME] = $default;
  Iterators[TAG] = returnThis;
  if (DEFAULT) {
    methods = {
      values: DEF_VALUES ? $default : getMethod(VALUES),
      keys: IS_SET ? $default : getMethod(KEYS),
      entries: $entries
    };
    if (FORCED) for (key in methods) {
      if (!(key in proto)) redefine(proto, key, methods[key]);
    } else $export($export.P + $export.F * (BUGGY || VALUES_BUG), NAME, methods);
  }
  return methods;
};


/***/ }),

/***/ "07e3":
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;
module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),

/***/ "0d58":
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.14 / 15.2.3.14 Object.keys(O)
var $keys = __webpack_require__("ce10");
var enumBugKeys = __webpack_require__("e11e");

module.exports = Object.keys || function keys(O) {
  return $keys(O, enumBugKeys);
};


/***/ }),

/***/ "11e9":
/***/ (function(module, exports, __webpack_require__) {

var pIE = __webpack_require__("52a7");
var createDesc = __webpack_require__("4630");
var toIObject = __webpack_require__("6821");
var toPrimitive = __webpack_require__("6a99");
var has = __webpack_require__("69a8");
var IE8_DOM_DEFINE = __webpack_require__("c69a");
var gOPD = Object.getOwnPropertyDescriptor;

exports.f = __webpack_require__("9e1e") ? gOPD : function getOwnPropertyDescriptor(O, P) {
  O = toIObject(O);
  P = toPrimitive(P, true);
  if (IE8_DOM_DEFINE) try {
    return gOPD(O, P);
  } catch (e) { /* empty */ }
  if (has(O, P)) return createDesc(!pIE.f.call(O, P), O[P]);
};


/***/ }),

/***/ "1495":
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__("86cc");
var anObject = __webpack_require__("cb7c");
var getKeys = __webpack_require__("0d58");

module.exports = __webpack_require__("9e1e") ? Object.defineProperties : function defineProperties(O, Properties) {
  anObject(O);
  var keys = getKeys(Properties);
  var length = keys.length;
  var i = 0;
  var P;
  while (length > i) dP.f(O, P = keys[i++], Properties[P]);
  return O;
};


/***/ }),

/***/ "1bc3":
/***/ (function(module, exports, __webpack_require__) {

// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = __webpack_require__("f772");
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (it, S) {
  if (!isObject(it)) return it;
  var fn, val;
  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),

/***/ "1ec9":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("f772");
var document = __webpack_require__("e53d").document;
// typeof document.createElement is 'object' in old IE
var is = isObject(document) && isObject(document.createElement);
module.exports = function (it) {
  return is ? document.createElement(it) : {};
};


/***/ }),

/***/ "230e":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("d3f4");
var document = __webpack_require__("7726").document;
// typeof document.createElement is 'object' in old IE
var is = isObject(document) && isObject(document.createElement);
module.exports = function (it) {
  return is ? document.createElement(it) : {};
};


/***/ }),

/***/ "2350":
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),

/***/ "25c4":
/***/ (function(module) {

module.exports = [{"search":{"terms":[]},"styles":["brands"],"unicode":"f26e","label":"500px","free":["brands"],"class":"500px"},{"search":{"terms":["accessibility","handicap","person","wheelchair","wheelchair-alt"]},"styles":["brands"],"unicode":"f368","label":"Accessible Icon","free":["brands"],"class":"accessible-icon"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f369","label":"Accusoft","free":["brands"],"class":"accusoft"},{"search":{"terms":["Dungeons & Dragons","d&d","dnd","fantasy","game","gaming","tabletop"]},"styles":["brands"],"unicode":"f6af","label":"Acquisitions Incorporated","free":["brands"],"class":"acquisitions-incorporated"},{"search":{"terms":["advertisement","media","newspaper","promotion","publicity"]},"styles":["solid"],"unicode":"f641","label":"Ad","free":["solid"],"class":"ad"},{"search":{"terms":["contact","directory","index","little black book","rolodex"]},"styles":["solid","regular"],"unicode":"f2b9","label":"Address Book","free":["solid","regular"],"class":"address-book"},{"search":{"terms":["about","contact","id","identification","postcard","profile"]},"styles":["solid","regular"],"unicode":"f2bb","label":"Address Card","free":["solid","regular"],"class":"address-card"},{"search":{"terms":["contrast","dark","light","saturation"]},"styles":["solid"],"unicode":"f042","label":"adjust","free":["solid"],"class":"adjust"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f170","label":"App.net","free":["brands"],"class":"adn"},{"search":{"terms":["acrobat","app","design","illustrator","indesign","photoshop"]},"styles":["brands"],"unicode":"f778","label":"Adobe","free":["brands"],"class":"adobe"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f36a","label":"Adversal","free":["brands"],"class":"adversal"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f36b","label":"affiliatetheme","free":["brands"],"class":"affiliatetheme"},{"search":{"terms":["car","deodorize","fresh","pine","scent"]},"styles":["solid"],"unicode":"f5d0","label":"Air Freshener","free":["solid"],"class":"air-freshener"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f834","label":"Airbnb","free":["brands"],"class":"airbnb"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f36c","label":"Algolia","free":["brands"],"class":"algolia"},{"search":{"terms":["format","middle","paragraph","text"]},"styles":["solid"],"unicode":"f037","label":"align-center","free":["solid"],"class":"align-center"},{"search":{"terms":["format","paragraph","text"]},"styles":["solid"],"unicode":"f039","label":"align-justify","free":["solid"],"class":"align-justify"},{"search":{"terms":["format","paragraph","text"]},"styles":["solid"],"unicode":"f036","label":"align-left","free":["solid"],"class":"align-left"},{"search":{"terms":["format","paragraph","text"]},"styles":["solid"],"unicode":"f038","label":"align-right","free":["solid"],"class":"align-right"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f642","label":"Alipay","free":["brands"],"class":"alipay"},{"search":{"terms":["allergy","freckles","hand","hives","pox","skin","spots"]},"styles":["solid"],"unicode":"f461","label":"Allergies","free":["solid"],"class":"allergies"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f270","label":"Amazon","free":["brands"],"class":"amazon"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f42c","label":"Amazon Pay","free":["brands"],"class":"amazon-pay"},{"search":{"terms":["emergency","emt","er","help","hospital","support","vehicle"]},"styles":["solid"],"unicode":"f0f9","label":"ambulance","free":["solid"],"class":"ambulance"},{"search":{"terms":["asl","deaf","finger","hand","interpret","speak"]},"styles":["solid"],"unicode":"f2a3","label":"American Sign Language Interpreting","free":["solid"],"class":"american-sign-language-interpreting"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f36d","label":"Amilia","free":["brands"],"class":"amilia"},{"search":{"terms":["berth","boat","dock","embed","link","maritime","moor","secure"]},"styles":["solid"],"unicode":"f13d","label":"Anchor","free":["solid"],"class":"anchor"},{"search":{"terms":["robot"]},"styles":["brands"],"unicode":"f17b","label":"Android","free":["brands"],"class":"android"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f209","label":"AngelList","free":["brands"],"class":"angellist"},{"search":{"terms":["arrows","caret","download","expand"]},"styles":["solid"],"unicode":"f103","label":"Angle Double Down","free":["solid"],"class":"angle-double-down"},{"search":{"terms":["arrows","back","caret","laquo","previous","quote"]},"styles":["solid"],"unicode":"f100","label":"Angle Double Left","free":["solid"],"class":"angle-double-left"},{"search":{"terms":["arrows","caret","forward","more","next","quote","raquo"]},"styles":["solid"],"unicode":"f101","label":"Angle Double Right","free":["solid"],"class":"angle-double-right"},{"search":{"terms":["arrows","caret","collapse","upload"]},"styles":["solid"],"unicode":"f102","label":"Angle Double Up","free":["solid"],"class":"angle-double-up"},{"search":{"terms":["arrow","caret","download","expand"]},"styles":["solid"],"unicode":"f107","label":"angle-down","free":["solid"],"class":"angle-down"},{"search":{"terms":["arrow","back","caret","less","previous"]},"styles":["solid"],"unicode":"f104","label":"angle-left","free":["solid"],"class":"angle-left"},{"search":{"terms":["arrow","care","forward","more","next"]},"styles":["solid"],"unicode":"f105","label":"angle-right","free":["solid"],"class":"angle-right"},{"search":{"terms":["arrow","caret","collapse","upload"]},"styles":["solid"],"unicode":"f106","label":"angle-up","free":["solid"],"class":"angle-up"},{"search":{"terms":["disapprove","emoticon","face","mad","upset"]},"styles":["solid","regular"],"unicode":"f556","label":"Angry Face","free":["solid","regular"],"class":"angry"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f36e","label":"Angry Creative","free":["brands"],"class":"angrycreative"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f420","label":"Angular","free":["brands"],"class":"angular"},{"search":{"terms":["amulet","copper","coptic christianity","copts","crux ansata","egypt","venus"]},"styles":["solid"],"unicode":"f644","label":"Ankh","free":["solid"],"class":"ankh"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f36f","label":"App Store","free":["brands"],"class":"app-store"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f370","label":"iOS App Store","free":["brands"],"class":"app-store-ios"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f371","label":"Apper Systems AB","free":["brands"],"class":"apper"},{"search":{"terms":["fruit","ios","mac","operating system","os","osx"]},"styles":["brands"],"unicode":"f179","label":"Apple","free":["brands"],"class":"apple"},{"search":{"terms":["fall","fruit","fuji","macintosh","orchard","seasonal","vegan"]},"styles":["solid"],"unicode":"f5d1","label":"Fruit Apple","free":["solid"],"class":"apple-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f415","label":"Apple Pay","free":["brands"],"class":"apple-pay"},{"search":{"terms":["box","package","save","storage"]},"styles":["solid"],"unicode":"f187","label":"Archive","free":["solid"],"class":"archive"},{"search":{"terms":["arc","monument","road","street","tunnel"]},"styles":["solid"],"unicode":"f557","label":"Archway","free":["solid"],"class":"archway"},{"search":{"terms":["arrow-circle-o-down","download"]},"styles":["solid","regular"],"unicode":"f358","label":"Alternate Arrow Circle Down","free":["solid","regular"],"class":"arrow-alt-circle-down"},{"search":{"terms":["arrow-circle-o-left","back","previous"]},"styles":["solid","regular"],"unicode":"f359","label":"Alternate Arrow Circle Left","free":["solid","regular"],"class":"arrow-alt-circle-left"},{"search":{"terms":["arrow-circle-o-right","forward","next"]},"styles":["solid","regular"],"unicode":"f35a","label":"Alternate Arrow Circle Right","free":["solid","regular"],"class":"arrow-alt-circle-right"},{"search":{"terms":["arrow-circle-o-up"]},"styles":["solid","regular"],"unicode":"f35b","label":"Alternate Arrow Circle Up","free":["solid","regular"],"class":"arrow-alt-circle-up"},{"search":{"terms":["download"]},"styles":["solid"],"unicode":"f0ab","label":"Arrow Circle Down","free":["solid"],"class":"arrow-circle-down"},{"search":{"terms":["back","previous"]},"styles":["solid"],"unicode":"f0a8","label":"Arrow Circle Left","free":["solid"],"class":"arrow-circle-left"},{"search":{"terms":["forward","next"]},"styles":["solid"],"unicode":"f0a9","label":"Arrow Circle Right","free":["solid"],"class":"arrow-circle-right"},{"search":{"terms":["upload"]},"styles":["solid"],"unicode":"f0aa","label":"Arrow Circle Up","free":["solid"],"class":"arrow-circle-up"},{"search":{"terms":["download"]},"styles":["solid"],"unicode":"f063","label":"arrow-down","free":["solid"],"class":"arrow-down"},{"search":{"terms":["back","previous"]},"styles":["solid"],"unicode":"f060","label":"arrow-left","free":["solid"],"class":"arrow-left"},{"search":{"terms":["forward","next"]},"styles":["solid"],"unicode":"f061","label":"arrow-right","free":["solid"],"class":"arrow-right"},{"search":{"terms":["forward","upload"]},"styles":["solid"],"unicode":"f062","label":"arrow-up","free":["solid"],"class":"arrow-up"},{"search":{"terms":["arrow","arrows","bigger","enlarge","expand","fullscreen","move","position","reorder","resize"]},"styles":["solid"],"unicode":"f0b2","label":"Alternate Arrows","free":["solid"],"class":"arrows-alt"},{"search":{"terms":["arrows-h","expand","horizontal","landscape","resize","wide"]},"styles":["solid"],"unicode":"f337","label":"Alternate Arrows Horizontal","free":["solid"],"class":"arrows-alt-h"},{"search":{"terms":["arrows-v","expand","portrait","resize","tall","vertical"]},"styles":["solid"],"unicode":"f338","label":"Alternate Arrows Vertical","free":["solid"],"class":"arrows-alt-v"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f77a","label":"Artstation","free":["brands"],"class":"artstation"},{"search":{"terms":["amplify","audio","deaf","ear","headset","hearing","sound"]},"styles":["solid"],"unicode":"f2a2","label":"Assistive Listening Systems","free":["solid"],"class":"assistive-listening-systems"},{"search":{"terms":["annotation","details","reference","star"]},"styles":["solid"],"unicode":"f069","label":"asterisk","free":["solid"],"class":"asterisk"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f372","label":"Asymmetrik, Ltd.","free":["brands"],"class":"asymmetrik"},{"search":{"terms":["address","author","e-mail","email","handle"]},"styles":["solid"],"unicode":"f1fa","label":"At","free":["solid"],"class":"at"},{"search":{"terms":["book","directions","geography","globe","map","travel","wayfinding"]},"styles":["solid"],"unicode":"f558","label":"Atlas","free":["solid"],"class":"atlas"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f77b","label":"Atlassian","free":["brands"],"class":"atlassian"},{"search":{"terms":["atheism","chemistry","ion","nuclear","science"]},"styles":["solid"],"unicode":"f5d2","label":"Atom","free":["solid"],"class":"atom"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f373","label":"Audible","free":["brands"],"class":"audible"},{"search":{"terms":["blind","narration","video","visual"]},"styles":["solid"],"unicode":"f29e","label":"Audio Description","free":["solid"],"class":"audio-description"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f41c","label":"Autoprefixer","free":["brands"],"class":"autoprefixer"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f374","label":"avianex","free":["brands"],"class":"avianex"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f421","label":"Aviato","free":["brands"],"class":"aviato"},{"search":{"terms":["honor","praise","prize","recognition","ribbon","trophy"]},"styles":["solid"],"unicode":"f559","label":"Award","free":["solid"],"class":"award"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f375","label":"Amazon Web Services (AWS)","free":["brands"],"class":"aws"},{"search":{"terms":["child","diaper","doll","human","infant","kid","offspring","person","sprout"]},"styles":["solid"],"unicode":"f77c","label":"Baby","free":["solid"],"class":"baby"},{"search":{"terms":["buggy","carrier","infant","push","stroller","transportation","walk","wheels"]},"styles":["solid"],"unicode":"f77d","label":"Baby Carriage","free":["solid"],"class":"baby-carriage"},{"search":{"terms":["command","delete","erase","keyboard","undo"]},"styles":["solid"],"unicode":"f55a","label":"Backspace","free":["solid"],"class":"backspace"},{"search":{"terms":["previous","rewind"]},"styles":["solid"],"unicode":"f04a","label":"backward","free":["solid"],"class":"backward"},{"search":{"terms":["blt","breakfast","ham","lard","meat","pancetta","pork","rasher"]},"styles":["solid"],"unicode":"f7e5","label":"Bacon","free":["solid"],"class":"bacon"},{"search":{"terms":["balanced","justice","legal","measure","weight"]},"styles":["solid"],"unicode":"f24e","label":"Balance Scale","free":["solid"],"class":"balance-scale"},{"search":{"terms":["justice","legal","measure","unbalanced","weight"]},"styles":["solid"],"unicode":"f515","label":"Balance Scale (Left-Weighted)","free":["solid"],"class":"balance-scale-left"},{"search":{"terms":["justice","legal","measure","unbalanced","weight"]},"styles":["solid"],"unicode":"f516","label":"Balance Scale (Right-Weighted)","free":["solid"],"class":"balance-scale-right"},{"search":{"terms":["abort","ban","block","cancel","delete","hide","prohibit","remove","stop","trash"]},"styles":["solid"],"unicode":"f05e","label":"ban","free":["solid"],"class":"ban"},{"search":{"terms":["bandage","boo boo","first aid","ouch"]},"styles":["solid"],"unicode":"f462","label":"Band-Aid","free":["solid"],"class":"band-aid"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2d5","label":"Bandcamp","free":["brands"],"class":"bandcamp"},{"search":{"terms":["info","laser","price","scan","upc"]},"styles":["solid"],"unicode":"f02a","label":"barcode","free":["solid"],"class":"barcode"},{"search":{"terms":["checklist","drag","hamburger","list","menu","nav","navigation","ol","reorder","settings","todo","ul"]},"styles":["solid"],"unicode":"f0c9","label":"Bars","free":["solid"],"class":"bars"},{"search":{"terms":["foul","hardball","league","leather","mlb","softball","sport"]},"styles":["solid"],"unicode":"f433","label":"Baseball Ball","free":["solid"],"class":"baseball-ball"},{"search":{"terms":["dribble","dunk","hoop","nba"]},"styles":["solid"],"unicode":"f434","label":"Basketball Ball","free":["solid"],"class":"basketball-ball"},{"search":{"terms":["clean","shower","tub","wash"]},"styles":["solid"],"unicode":"f2cd","label":"Bath","free":["solid"],"class":"bath"},{"search":{"terms":["charge","dead","power","status"]},"styles":["solid"],"unicode":"f244","label":"Battery Empty","free":["solid"],"class":"battery-empty"},{"search":{"terms":["charge","power","status"]},"styles":["solid"],"unicode":"f240","label":"Battery Full","free":["solid"],"class":"battery-full"},{"search":{"terms":["charge","power","status"]},"styles":["solid"],"unicode":"f242","label":"Battery 1/2 Full","free":["solid"],"class":"battery-half"},{"search":{"terms":["charge","low","power","status"]},"styles":["solid"],"unicode":"f243","label":"Battery 1/4 Full","free":["solid"],"class":"battery-quarter"},{"search":{"terms":["charge","power","status"]},"styles":["solid"],"unicode":"f241","label":"Battery 3/4 Full","free":["solid"],"class":"battery-three-quarters"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f835","label":"Battle.net","free":["brands"],"class":"battle-net"},{"search":{"terms":["lodging","rest","sleep","travel"]},"styles":["solid"],"unicode":"f236","label":"Bed","free":["solid"],"class":"bed"},{"search":{"terms":["alcohol","ale","bar","beverage","brewery","drink","lager","liquor","mug","stein"]},"styles":["solid"],"unicode":"f0fc","label":"beer","free":["solid"],"class":"beer"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1b4","label":"Behance","free":["brands"],"class":"behance"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1b5","label":"Behance Square","free":["brands"],"class":"behance-square"},{"search":{"terms":["alarm","alert","chime","notification","reminder"]},"styles":["solid","regular"],"unicode":"f0f3","label":"bell","free":["solid","regular"],"class":"bell"},{"search":{"terms":["alert","cancel","disabled","notification","off","reminder"]},"styles":["solid","regular"],"unicode":"f1f6","label":"Bell Slash","free":["solid","regular"],"class":"bell-slash"},{"search":{"terms":["curves","illustrator","lines","path","vector"]},"styles":["solid"],"unicode":"f55b","label":"Bezier Curve","free":["solid"],"class":"bezier-curve"},{"search":{"terms":["book","catholicism","christianity","god","holy"]},"styles":["solid"],"unicode":"f647","label":"Bible","free":["solid"],"class":"bible"},{"search":{"terms":["bike","gears","pedal","transportation","vehicle"]},"styles":["solid"],"unicode":"f206","label":"Bicycle","free":["solid"],"class":"bicycle"},{"search":{"terms":["bicycle","bike","cycle","cycling","ride","wheel"]},"styles":["solid"],"unicode":"f84a","label":"Biking","free":["solid"],"class":"biking"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f378","label":"BIMobject","free":["brands"],"class":"bimobject"},{"search":{"terms":["glasses","magnify","scenic","spyglass","view"]},"styles":["solid"],"unicode":"f1e5","label":"Binoculars","free":["solid"],"class":"binoculars"},{"search":{"terms":["danger","dangerous","hazmat","medical","radioactive","toxic","waste","zombie"]},"styles":["solid"],"unicode":"f780","label":"Biohazard","free":["solid"],"class":"biohazard"},{"search":{"terms":["anniversary","bakery","candles","celebration","dessert","frosting","holiday","party","pastry"]},"styles":["solid"],"unicode":"f1fd","label":"Birthday Cake","free":["solid"],"class":"birthday-cake"},{"search":{"terms":["atlassian","bitbucket-square","git"]},"styles":["brands"],"unicode":"f171","label":"Bitbucket","free":["brands"],"class":"bitbucket"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f379","label":"Bitcoin","free":["brands"],"class":"bitcoin"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f37a","label":"Bity","free":["brands"],"class":"bity"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f27e","label":"Font Awesome Black Tie","free":["brands"],"class":"black-tie"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f37b","label":"BlackBerry","free":["brands"],"class":"blackberry"},{"search":{"terms":["cocktail","milkshake","mixer","puree","smoothie"]},"styles":["solid"],"unicode":"f517","label":"Blender","free":["solid"],"class":"blender"},{"search":{"terms":["appliance","cocktail","communication","fantasy","milkshake","mixer","puree","silly","smoothie"]},"styles":["solid"],"unicode":"f6b6","label":"Blender Phone","free":["solid"],"class":"blender-phone"},{"search":{"terms":["cane","disability","person","sight"]},"styles":["solid"],"unicode":"f29d","label":"Blind","free":["solid"],"class":"blind"},{"search":{"terms":["journal","log","online","personal","post","web 2.0","wordpress","writing"]},"styles":["solid"],"unicode":"f781","label":"Blog","free":["solid"],"class":"blog"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f37c","label":"Blogger","free":["brands"],"class":"blogger"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f37d","label":"Blogger B","free":["brands"],"class":"blogger-b"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f293","label":"Bluetooth","free":["brands"],"class":"bluetooth"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f294","label":"Bluetooth","free":["brands"],"class":"bluetooth-b"},{"search":{"terms":["emphasis","format","text"]},"styles":["solid"],"unicode":"f032","label":"bold","free":["solid"],"class":"bold"},{"search":{"terms":["electricity","lightning","weather","zap"]},"styles":["solid"],"unicode":"f0e7","label":"Lightning Bolt","free":["solid"],"class":"bolt"},{"search":{"terms":["error","explode","fuse","grenade","warning"]},"styles":["solid"],"unicode":"f1e2","label":"Bomb","free":["solid"],"class":"bomb"},{"search":{"terms":["calcium","dog","skeletal","skeleton","tibia"]},"styles":["solid"],"unicode":"f5d7","label":"Bone","free":["solid"],"class":"bone"},{"search":{"terms":["aparatus","cannabis","marijuana","pipe","smoke","smoking"]},"styles":["solid"],"unicode":"f55c","label":"Bong","free":["solid"],"class":"bong"},{"search":{"terms":["diary","documentation","journal","library","read"]},"styles":["solid"],"unicode":"f02d","label":"book","free":["solid"],"class":"book"},{"search":{"terms":["Dungeons & Dragons","crossbones","d&d","dark arts","death","dnd","documentation","evil","fantasy","halloween","holiday","necronomicon","read","skull","spell"]},"styles":["solid"],"unicode":"f6b7","label":"Book of the Dead","free":["solid"],"class":"book-dead"},{"search":{"terms":["diary","documentation","health","history","journal","library","read","record"]},"styles":["solid"],"unicode":"f7e6","label":"Medical Book","free":["solid"],"class":"book-medical"},{"search":{"terms":["flyer","library","notebook","open book","pamphlet","reading"]},"styles":["solid"],"unicode":"f518","label":"Book Open","free":["solid"],"class":"book-open"},{"search":{"terms":["flyer","library","notebook","open book","pamphlet","reading"]},"styles":["solid"],"unicode":"f5da","label":"Book Reader","free":["solid"],"class":"book-reader"},{"search":{"terms":["favorite","marker","read","remember","save"]},"styles":["solid","regular"],"unicode":"f02e","label":"bookmark","free":["solid","regular"],"class":"bookmark"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f836","label":"Bootstrap","free":["brands"],"class":"bootstrap"},{"search":{"terms":["cell","grid","outline","stroke","table"]},"styles":["solid"],"unicode":"f84c","label":"Border All","free":["solid"],"class":"border-all"},{"search":{"terms":["cell","grid","outline","stroke","table"]},"styles":["solid"],"unicode":"f850","label":"Border None","free":["solid"],"class":"border-none"},{"search":{"terms":[]},"styles":["solid"],"unicode":"f853","label":"Border Style","free":["solid"],"class":"border-style"},{"search":{"terms":["alley","candlepin","gutter","lane","strike","tenpin"]},"styles":["solid"],"unicode":"f436","label":"Bowling Ball","free":["solid"],"class":"bowling-ball"},{"search":{"terms":["archive","container","package","storage"]},"styles":["solid"],"unicode":"f466","label":"Box","free":["solid"],"class":"box"},{"search":{"terms":["archive","container","package","storage","unpack"]},"styles":["solid"],"unicode":"f49e","label":"Box Open","free":["solid"],"class":"box-open"},{"search":{"terms":["archives","inventory","storage","warehouse"]},"styles":["solid"],"unicode":"f468","label":"Boxes","free":["solid"],"class":"boxes"},{"search":{"terms":["alphabet","blind","dots","raised","vision"]},"styles":["solid"],"unicode":"f2a1","label":"Braille","free":["solid"],"class":"braille"},{"search":{"terms":["cerebellum","gray matter","intellect","medulla oblongata","mind","noodle","wit"]},"styles":["solid"],"unicode":"f5dc","label":"Brain","free":["solid"],"class":"brain"},{"search":{"terms":["bake","bakery","baking","dough","flour","gluten","grain","sandwich","sourdough","toast","wheat","yeast"]},"styles":["solid"],"unicode":"f7ec","label":"Bread Slice","free":["solid"],"class":"bread-slice"},{"search":{"terms":["bag","business","luggage","office","work"]},"styles":["solid"],"unicode":"f0b1","label":"Briefcase","free":["solid"],"class":"briefcase"},{"search":{"terms":["doctor","emt","first aid","health"]},"styles":["solid"],"unicode":"f469","label":"Medical Briefcase","free":["solid"],"class":"briefcase-medical"},{"search":{"terms":["airwaves","antenna","radio","reception","waves"]},"styles":["solid"],"unicode":"f519","label":"Broadcast Tower","free":["solid"],"class":"broadcast-tower"},{"search":{"terms":["clean","firebolt","fly","halloween","nimbus 2000","quidditch","sweep","witch"]},"styles":["solid"],"unicode":"f51a","label":"Broom","free":["solid"],"class":"broom"},{"search":{"terms":["art","bristles","color","handle","paint"]},"styles":["solid"],"unicode":"f55d","label":"Brush","free":["solid"],"class":"brush"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f15a","label":"BTC","free":["brands"],"class":"btc"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f837","label":"Buffer","free":["brands"],"class":"buffer"},{"search":{"terms":["beetle","error","insect","report"]},"styles":["solid"],"unicode":"f188","label":"Bug","free":["solid"],"class":"bug"},{"search":{"terms":["apartment","business","city","company","office","work"]},"styles":["solid","regular"],"unicode":"f1ad","label":"Building","free":["solid","regular"],"class":"building"},{"search":{"terms":["announcement","broadcast","louder","megaphone","share"]},"styles":["solid"],"unicode":"f0a1","label":"bullhorn","free":["solid"],"class":"bullhorn"},{"search":{"terms":["archery","goal","objective","target"]},"styles":["solid"],"unicode":"f140","label":"Bullseye","free":["solid"],"class":"bullseye"},{"search":{"terms":["caliente","energy","fire","flame","gas","heat","hot"]},"styles":["solid"],"unicode":"f46a","label":"Burn","free":["solid"],"class":"burn"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f37f","label":"Büromöbel-Experte GmbH & Co. KG.","free":["brands"],"class":"buromobelexperte"},{"search":{"terms":["public transportation","transportation","travel","vehicle"]},"styles":["solid"],"unicode":"f207","label":"Bus","free":["solid"],"class":"bus"},{"search":{"terms":["mta","public transportation","transportation","travel","vehicle"]},"styles":["solid"],"unicode":"f55e","label":"Bus Alt","free":["solid"],"class":"bus-alt"},{"search":{"terms":["alarm","briefcase","business socks","clock","flight of the conchords","reminder","wednesday"]},"styles":["solid"],"unicode":"f64a","label":"Business Time","free":["solid"],"class":"business-time"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f20d","label":"BuySellAds","free":["brands"],"class":"buysellads"},{"search":{"terms":["abacus","addition","arithmetic","counting","math","multiplication","subtraction"]},"styles":["solid"],"unicode":"f1ec","label":"Calculator","free":["solid"],"class":"calculator"},{"search":{"terms":["calendar-o","date","event","schedule","time","when"]},"styles":["solid","regular"],"unicode":"f133","label":"Calendar","free":["solid","regular"],"class":"calendar"},{"search":{"terms":["calendar","date","event","schedule","time","when"]},"styles":["solid","regular"],"unicode":"f073","label":"Alternate Calendar","free":["solid","regular"],"class":"calendar-alt"},{"search":{"terms":["accept","agree","appointment","confirm","correct","date","done","event","ok","schedule","select","success","tick","time","todo","when"]},"styles":["solid","regular"],"unicode":"f274","label":"Calendar Check","free":["solid","regular"],"class":"calendar-check"},{"search":{"terms":["date","detail","event","focus","schedule","single day","time","today","when"]},"styles":["solid"],"unicode":"f783","label":"Calendar with Day Focus","free":["solid"],"class":"calendar-day"},{"search":{"terms":["calendar","date","delete","event","negative","remove","schedule","time","when"]},"styles":["solid","regular"],"unicode":"f272","label":"Calendar Minus","free":["solid","regular"],"class":"calendar-minus"},{"search":{"terms":["add","calendar","create","date","event","new","positive","schedule","time","when"]},"styles":["solid","regular"],"unicode":"f271","label":"Calendar Plus","free":["solid","regular"],"class":"calendar-plus"},{"search":{"terms":["archive","calendar","date","delete","event","remove","schedule","time","when","x"]},"styles":["solid","regular"],"unicode":"f273","label":"Calendar Times","free":["solid","regular"],"class":"calendar-times"},{"search":{"terms":["date","detail","event","focus","schedule","single week","time","today","when"]},"styles":["solid"],"unicode":"f784","label":"Calendar with Week Focus","free":["solid"],"class":"calendar-week"},{"search":{"terms":["image","lens","photo","picture","record","shutter","video"]},"styles":["solid"],"unicode":"f030","label":"camera","free":["solid"],"class":"camera"},{"search":{"terms":["image","lens","photo","picture","record","shutter","video"]},"styles":["solid"],"unicode":"f083","label":"Retro Camera","free":["solid"],"class":"camera-retro"},{"search":{"terms":["camping","fall","outdoors","teepee","tent","tipi"]},"styles":["solid"],"unicode":"f6bb","label":"Campground","free":["solid"],"class":"campground"},{"search":{"terms":["canada","flag","flora","nature","plant"]},"styles":["brands"],"unicode":"f785","label":"Canadian Maple Leaf","free":["brands"],"class":"canadian-maple-leaf"},{"search":{"terms":["candy","christmas","holiday","mint","peppermint","striped","xmas"]},"styles":["solid"],"unicode":"f786","label":"Candy Cane","free":["solid"],"class":"candy-cane"},{"search":{"terms":["bud","chronic","drugs","endica","endo","ganja","marijuana","mary jane","pot","reefer","sativa","spliff","weed","whacky-tabacky"]},"styles":["solid"],"unicode":"f55f","label":"Cannabis","free":["solid"],"class":"cannabis"},{"search":{"terms":["drugs","medicine","pills","prescription"]},"styles":["solid"],"unicode":"f46b","label":"Capsules","free":["solid"],"class":"capsules"},{"search":{"terms":["auto","automobile","sedan","transportation","travel","vehicle"]},"styles":["solid"],"unicode":"f1b9","label":"Car","free":["solid"],"class":"car"},{"search":{"terms":["auto","automobile","sedan","transportation","travel","vehicle"]},"styles":["solid"],"unicode":"f5de","label":"Alternate Car","free":["solid"],"class":"car-alt"},{"search":{"terms":["auto","electric","mechanic","power"]},"styles":["solid"],"unicode":"f5df","label":"Car Battery","free":["solid"],"class":"car-battery"},{"search":{"terms":["accident","auto","automobile","insurance","sedan","transportation","vehicle","wreck"]},"styles":["solid"],"unicode":"f5e1","label":"Car Crash","free":["solid"],"class":"car-crash"},{"search":{"terms":["auto","automobile","sedan","transportation","travel","vehicle"]},"styles":["solid"],"unicode":"f5e4","label":"Car Side","free":["solid"],"class":"car-side"},{"search":{"terms":["arrow","dropdown","expand","menu","more","triangle"]},"styles":["solid"],"unicode":"f0d7","label":"Caret Down","free":["solid"],"class":"caret-down"},{"search":{"terms":["arrow","back","previous","triangle"]},"styles":["solid"],"unicode":"f0d9","label":"Caret Left","free":["solid"],"class":"caret-left"},{"search":{"terms":["arrow","forward","next","triangle"]},"styles":["solid"],"unicode":"f0da","label":"Caret Right","free":["solid"],"class":"caret-right"},{"search":{"terms":["arrow","caret-square-o-down","dropdown","expand","menu","more","triangle"]},"styles":["solid","regular"],"unicode":"f150","label":"Caret Square Down","free":["solid","regular"],"class":"caret-square-down"},{"search":{"terms":["arrow","back","caret-square-o-left","previous","triangle"]},"styles":["solid","regular"],"unicode":"f191","label":"Caret Square Left","free":["solid","regular"],"class":"caret-square-left"},{"search":{"terms":["arrow","caret-square-o-right","forward","next","triangle"]},"styles":["solid","regular"],"unicode":"f152","label":"Caret Square Right","free":["solid","regular"],"class":"caret-square-right"},{"search":{"terms":["arrow","caret-square-o-up","collapse","triangle","upload"]},"styles":["solid","regular"],"unicode":"f151","label":"Caret Square Up","free":["solid","regular"],"class":"caret-square-up"},{"search":{"terms":["arrow","collapse","triangle"]},"styles":["solid"],"unicode":"f0d8","label":"Caret Up","free":["solid"],"class":"caret-up"},{"search":{"terms":["bugs bunny","orange","vegan","vegetable"]},"styles":["solid"],"unicode":"f787","label":"Carrot","free":["solid"],"class":"carrot"},{"search":{"terms":["download","save","shopping"]},"styles":["solid"],"unicode":"f218","label":"Shopping Cart Arrow Down","free":["solid"],"class":"cart-arrow-down"},{"search":{"terms":["add","create","new","positive","shopping"]},"styles":["solid"],"unicode":"f217","label":"Add to Shopping Cart","free":["solid"],"class":"cart-plus"},{"search":{"terms":["buy","cha-ching","change","checkout","commerce","leaerboard","machine","pay","payment","purchase","store"]},"styles":["solid"],"unicode":"f788","label":"Cash Register","free":["solid"],"class":"cash-register"},{"search":{"terms":["feline","halloween","holiday","kitten","kitty","meow","pet"]},"styles":["solid"],"unicode":"f6be","label":"Cat","free":["solid"],"class":"cat"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f42d","label":"Amazon Pay Credit Card","free":["brands"],"class":"cc-amazon-pay"},{"search":{"terms":["amex"]},"styles":["brands"],"unicode":"f1f3","label":"American Express Credit Card","free":["brands"],"class":"cc-amex"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f416","label":"Apple Pay Credit Card","free":["brands"],"class":"cc-apple-pay"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f24c","label":"Diner's Club Credit Card","free":["brands"],"class":"cc-diners-club"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1f2","label":"Discover Credit Card","free":["brands"],"class":"cc-discover"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f24b","label":"JCB Credit Card","free":["brands"],"class":"cc-jcb"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1f1","label":"MasterCard Credit Card","free":["brands"],"class":"cc-mastercard"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1f4","label":"Paypal Credit Card","free":["brands"],"class":"cc-paypal"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1f5","label":"Stripe Credit Card","free":["brands"],"class":"cc-stripe"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1f0","label":"Visa Credit Card","free":["brands"],"class":"cc-visa"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f380","label":"Centercode","free":["brands"],"class":"centercode"},{"search":{"terms":["linux","operating system","os"]},"styles":["brands"],"unicode":"f789","label":"Centos","free":["brands"],"class":"centos"},{"search":{"terms":["badge","star","verified"]},"styles":["solid"],"unicode":"f0a3","label":"certificate","free":["solid"],"class":"certificate"},{"search":{"terms":["furniture","seat","sit"]},"styles":["solid"],"unicode":"f6c0","label":"Chair","free":["solid"],"class":"chair"},{"search":{"terms":["blackboard","learning","school","teaching","whiteboard","writing"]},"styles":["solid"],"unicode":"f51b","label":"Chalkboard","free":["solid"],"class":"chalkboard"},{"search":{"terms":["blackboard","instructor","learning","professor","school","whiteboard","writing"]},"styles":["solid"],"unicode":"f51c","label":"Chalkboard Teacher","free":["solid"],"class":"chalkboard-teacher"},{"search":{"terms":["electric","ev","tesla","vehicle"]},"styles":["solid"],"unicode":"f5e7","label":"Charging Station","free":["solid"],"class":"charging-station"},{"search":{"terms":["analytics","area","chart","graph"]},"styles":["solid"],"unicode":"f1fe","label":"Area Chart","free":["solid"],"class":"chart-area"},{"search":{"terms":["analytics","bar","chart","graph"]},"styles":["solid","regular"],"unicode":"f080","label":"Bar Chart","free":["solid","regular"],"class":"chart-bar"},{"search":{"terms":["activity","analytics","chart","dashboard","gain","graph","increase","line"]},"styles":["solid"],"unicode":"f201","label":"Line Chart","free":["solid"],"class":"chart-line"},{"search":{"terms":["analytics","chart","diagram","graph","pie"]},"styles":["solid"],"unicode":"f200","label":"Pie Chart","free":["solid"],"class":"chart-pie"},{"search":{"terms":["accept","agree","checkmark","confirm","correct","done","notice","notification","notify","ok","select","success","tick","todo","yes"]},"styles":["solid"],"unicode":"f00c","label":"Check","free":["solid"],"class":"check"},{"search":{"terms":["accept","agree","confirm","correct","done","ok","select","success","tick","todo","yes"]},"styles":["solid","regular"],"unicode":"f058","label":"Check Circle","free":["solid","regular"],"class":"check-circle"},{"search":{"terms":["accept","agree","checkmark","confirm","correct","done","notice","notification","notify","ok","select","success","tick","todo"]},"styles":["solid"],"unicode":"f560","label":"Double Check","free":["solid"],"class":"check-double"},{"search":{"terms":["accept","agree","checkmark","confirm","correct","done","ok","select","success","tick","todo","yes"]},"styles":["solid","regular"],"unicode":"f14a","label":"Check Square","free":["solid","regular"],"class":"check-square"},{"search":{"terms":["cheddar","curd","gouda","melt","parmesan","sandwich","swiss","wedge"]},"styles":["solid"],"unicode":"f7ef","label":"Cheese","free":["solid"],"class":"cheese"},{"search":{"terms":["board","castle","checkmate","game","king","rook","strategy","tournament"]},"styles":["solid"],"unicode":"f439","label":"Chess","free":["solid"],"class":"chess"},{"search":{"terms":["board","checkmate","game","strategy"]},"styles":["solid"],"unicode":"f43a","label":"Chess Bishop","free":["solid"],"class":"chess-bishop"},{"search":{"terms":["board","checkmate","game","strategy"]},"styles":["solid"],"unicode":"f43c","label":"Chess Board","free":["solid"],"class":"chess-board"},{"search":{"terms":["board","checkmate","game","strategy"]},"styles":["solid"],"unicode":"f43f","label":"Chess King","free":["solid"],"class":"chess-king"},{"search":{"terms":["board","checkmate","game","horse","strategy"]},"styles":["solid"],"unicode":"f441","label":"Chess Knight","free":["solid"],"class":"chess-knight"},{"search":{"terms":["board","checkmate","game","strategy"]},"styles":["solid"],"unicode":"f443","label":"Chess Pawn","free":["solid"],"class":"chess-pawn"},{"search":{"terms":["board","checkmate","game","strategy"]},"styles":["solid"],"unicode":"f445","label":"Chess Queen","free":["solid"],"class":"chess-queen"},{"search":{"terms":["board","castle","checkmate","game","strategy"]},"styles":["solid"],"unicode":"f447","label":"Chess Rook","free":["solid"],"class":"chess-rook"},{"search":{"terms":["arrow","download","dropdown","menu","more"]},"styles":["solid"],"unicode":"f13a","label":"Chevron Circle Down","free":["solid"],"class":"chevron-circle-down"},{"search":{"terms":["arrow","back","previous"]},"styles":["solid"],"unicode":"f137","label":"Chevron Circle Left","free":["solid"],"class":"chevron-circle-left"},{"search":{"terms":["arrow","forward","next"]},"styles":["solid"],"unicode":"f138","label":"Chevron Circle Right","free":["solid"],"class":"chevron-circle-right"},{"search":{"terms":["arrow","collapse","upload"]},"styles":["solid"],"unicode":"f139","label":"Chevron Circle Up","free":["solid"],"class":"chevron-circle-up"},{"search":{"terms":["arrow","download","expand"]},"styles":["solid"],"unicode":"f078","label":"chevron-down","free":["solid"],"class":"chevron-down"},{"search":{"terms":["arrow","back","bracket","previous"]},"styles":["solid"],"unicode":"f053","label":"chevron-left","free":["solid"],"class":"chevron-left"},{"search":{"terms":["arrow","bracket","forward","next"]},"styles":["solid"],"unicode":"f054","label":"chevron-right","free":["solid"],"class":"chevron-right"},{"search":{"terms":["arrow","collapse","upload"]},"styles":["solid"],"unicode":"f077","label":"chevron-up","free":["solid"],"class":"chevron-up"},{"search":{"terms":["boy","girl","kid","toddler","young"]},"styles":["solid"],"unicode":"f1ae","label":"Child","free":["solid"],"class":"child"},{"search":{"terms":["browser"]},"styles":["brands"],"unicode":"f268","label":"Chrome","free":["brands"],"class":"chrome"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f838","label":"Chromecast","free":["brands"],"class":"chromecast"},{"search":{"terms":["building","cathedral","chapel","community","religion"]},"styles":["solid"],"unicode":"f51d","label":"Church","free":["solid"],"class":"church"},{"search":{"terms":["circle-thin","diameter","dot","ellipse","notification","round"]},"styles":["solid","regular"],"unicode":"f111","label":"Circle","free":["solid","regular"],"class":"circle"},{"search":{"terms":["circle-o-notch","diameter","dot","ellipse","round","spinner"]},"styles":["solid"],"unicode":"f1ce","label":"Circle Notched","free":["solid"],"class":"circle-notch"},{"search":{"terms":["buildings","busy","skyscrapers","urban","windows"]},"styles":["solid"],"unicode":"f64f","label":"City","free":["solid"],"class":"city"},{"search":{"terms":["doctor","general practitioner","hospital","infirmary","medicine","office","outpatient"]},"styles":["solid"],"unicode":"f7f2","label":"Medical Clinic","free":["solid"],"class":"clinic-medical"},{"search":{"terms":["copy","notes","paste","record"]},"styles":["solid","regular"],"unicode":"f328","label":"Clipboard","free":["solid","regular"],"class":"clipboard"},{"search":{"terms":["accept","agree","confirm","done","ok","select","success","tick","todo","yes"]},"styles":["solid"],"unicode":"f46c","label":"Clipboard with Check","free":["solid"],"class":"clipboard-check"},{"search":{"terms":["checklist","completed","done","finished","intinerary","ol","schedule","tick","todo","ul"]},"styles":["solid"],"unicode":"f46d","label":"Clipboard List","free":["solid"],"class":"clipboard-list"},{"search":{"terms":["date","late","schedule","time","timer","timestamp","watch"]},"styles":["solid","regular"],"unicode":"f017","label":"Clock","free":["solid","regular"],"class":"clock"},{"search":{"terms":["arrange","copy","duplicate","paste"]},"styles":["solid","regular"],"unicode":"f24d","label":"Clone","free":["solid","regular"],"class":"clone"},{"search":{"terms":["cc","deaf","hearing","subtitle","subtitling","text","video"]},"styles":["solid","regular"],"unicode":"f20a","label":"Closed Captioning","free":["solid","regular"],"class":"closed-captioning"},{"search":{"terms":["atmosphere","fog","overcast","save","upload","weather"]},"styles":["solid"],"unicode":"f0c2","label":"Cloud","free":["solid"],"class":"cloud"},{"search":{"terms":["download","export","save"]},"styles":["solid"],"unicode":"f381","label":"Alternate Cloud Download","free":["solid"],"class":"cloud-download-alt"},{"search":{"terms":["FLDSMDFR","food","spaghetti","storm"]},"styles":["solid"],"unicode":"f73b","label":"Cloud with (a chance of) Meatball","free":["solid"],"class":"cloud-meatball"},{"search":{"terms":["crescent","evening","lunar","night","partly cloudy","sky"]},"styles":["solid"],"unicode":"f6c3","label":"Cloud with Moon","free":["solid"],"class":"cloud-moon"},{"search":{"terms":["crescent","evening","lunar","night","partly cloudy","precipitation","rain","sky","storm"]},"styles":["solid"],"unicode":"f73c","label":"Cloud with Moon and Rain","free":["solid"],"class":"cloud-moon-rain"},{"search":{"terms":["precipitation","rain","sky","storm"]},"styles":["solid"],"unicode":"f73d","label":"Cloud with Rain","free":["solid"],"class":"cloud-rain"},{"search":{"terms":["precipitation","rain","sky","storm"]},"styles":["solid"],"unicode":"f740","label":"Cloud with Heavy Showers","free":["solid"],"class":"cloud-showers-heavy"},{"search":{"terms":["clear","day","daytime","fall","outdoors","overcast","partly cloudy"]},"styles":["solid"],"unicode":"f6c4","label":"Cloud with Sun","free":["solid"],"class":"cloud-sun"},{"search":{"terms":["day","overcast","precipitation","storm","summer","sunshower"]},"styles":["solid"],"unicode":"f743","label":"Cloud with Sun and Rain","free":["solid"],"class":"cloud-sun-rain"},{"search":{"terms":["cloud-upload","import","save","upload"]},"styles":["solid"],"unicode":"f382","label":"Alternate Cloud Upload","free":["solid"],"class":"cloud-upload-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f383","label":"cloudscale.ch","free":["brands"],"class":"cloudscale"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f384","label":"Cloudsmith","free":["brands"],"class":"cloudsmith"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f385","label":"cloudversify","free":["brands"],"class":"cloudversify"},{"search":{"terms":["alcohol","beverage","drink","gin","glass","margarita","martini","vodka"]},"styles":["solid"],"unicode":"f561","label":"Cocktail","free":["solid"],"class":"cocktail"},{"search":{"terms":["brackets","code","development","html"]},"styles":["solid"],"unicode":"f121","label":"Code","free":["solid"],"class":"code"},{"search":{"terms":["branch","code-fork","fork","git","github","rebase","svn","vcs","version"]},"styles":["solid"],"unicode":"f126","label":"Code Branch","free":["solid"],"class":"code-branch"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1cb","label":"Codepen","free":["brands"],"class":"codepen"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f284","label":"Codie Pie","free":["brands"],"class":"codiepie"},{"search":{"terms":["beverage","breakfast","cafe","drink","fall","morning","mug","seasonal","tea"]},"styles":["solid"],"unicode":"f0f4","label":"Coffee","free":["solid"],"class":"coffee"},{"search":{"terms":["gear","mechanical","settings","sprocket","wheel"]},"styles":["solid"],"unicode":"f013","label":"cog","free":["solid"],"class":"cog"},{"search":{"terms":["gears","mechanical","settings","sprocket","wheel"]},"styles":["solid"],"unicode":"f085","label":"cogs","free":["solid"],"class":"cogs"},{"search":{"terms":["currency","dime","financial","gold","money","penny"]},"styles":["solid"],"unicode":"f51e","label":"Coins","free":["solid"],"class":"coins"},{"search":{"terms":["browser","dashboard","organize","panes","split"]},"styles":["solid"],"unicode":"f0db","label":"Columns","free":["solid"],"class":"columns"},{"search":{"terms":["bubble","chat","commenting","conversation","feedback","message","note","notification","sms","speech","texting"]},"styles":["solid","regular"],"unicode":"f075","label":"comment","free":["solid","regular"],"class":"comment"},{"search":{"terms":["bubble","chat","commenting","conversation","feedback","message","note","notification","sms","speech","texting"]},"styles":["solid","regular"],"unicode":"f27a","label":"Alternate Comment","free":["solid","regular"],"class":"comment-alt"},{"search":{"terms":["bubble","chat","commenting","conversation","feedback","message","money","note","notification","pay","sms","speech","spend","texting","transfer"]},"styles":["solid"],"unicode":"f651","label":"Comment Dollar","free":["solid"],"class":"comment-dollar"},{"search":{"terms":["bubble","chat","commenting","conversation","feedback","message","more","note","notification","reply","sms","speech","texting"]},"styles":["solid","regular"],"unicode":"f4ad","label":"Comment Dots","free":["solid","regular"],"class":"comment-dots"},{"search":{"terms":["advice","bubble","chat","commenting","conversation","diagnose","feedback","message","note","notification","prescription","sms","speech","texting"]},"styles":["solid"],"unicode":"f7f5","label":"Alternate Medical Chat","free":["solid"],"class":"comment-medical"},{"search":{"terms":["bubble","cancel","chat","commenting","conversation","feedback","message","mute","note","notification","quiet","sms","speech","texting"]},"styles":["solid"],"unicode":"f4b3","label":"Comment Slash","free":["solid"],"class":"comment-slash"},{"search":{"terms":["bubble","chat","commenting","conversation","feedback","message","note","notification","sms","speech","texting"]},"styles":["solid","regular"],"unicode":"f086","label":"comments","free":["solid","regular"],"class":"comments"},{"search":{"terms":["bubble","chat","commenting","conversation","feedback","message","money","note","notification","pay","sms","speech","spend","texting","transfer"]},"styles":["solid"],"unicode":"f653","label":"Comments Dollar","free":["solid"],"class":"comments-dollar"},{"search":{"terms":["album","bluray","cd","disc","dvd","media","movie","music","record","video","vinyl"]},"styles":["solid"],"unicode":"f51f","label":"Compact Disc","free":["solid"],"class":"compact-disc"},{"search":{"terms":["directions","directory","location","menu","navigation","safari","travel"]},"styles":["solid","regular"],"unicode":"f14e","label":"Compass","free":["solid","regular"],"class":"compass"},{"search":{"terms":["collapse","fullscreen","minimize","move","resize","shrink","smaller"]},"styles":["solid"],"unicode":"f066","label":"Compress","free":["solid"],"class":"compress"},{"search":{"terms":["collapse","fullscreen","minimize","move","resize","shrink","smaller"]},"styles":["solid"],"unicode":"f78c","label":"Alternate Compress Arrows","free":["solid"],"class":"compress-arrows-alt"},{"search":{"terms":["attention","hotel","receptionist","service","support"]},"styles":["solid"],"unicode":"f562","label":"Concierge Bell","free":["solid"],"class":"concierge-bell"},{"search":{"terms":["atlassian"]},"styles":["brands"],"unicode":"f78d","label":"Confluence","free":["brands"],"class":"confluence"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f20e","label":"Connect Develop","free":["brands"],"class":"connectdevelop"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f26d","label":"Contao","free":["brands"],"class":"contao"},{"search":{"terms":["baked good","chips","chocolate","eat","snack","sweet","treat"]},"styles":["solid"],"unicode":"f563","label":"Cookie","free":["solid"],"class":"cookie"},{"search":{"terms":["baked good","bitten","chips","chocolate","eat","snack","sweet","treat"]},"styles":["solid"],"unicode":"f564","label":"Cookie Bite","free":["solid"],"class":"cookie-bite"},{"search":{"terms":["clone","duplicate","file","files-o","paper","paste"]},"styles":["solid","regular"],"unicode":"f0c5","label":"Copy","free":["solid","regular"],"class":"copy"},{"search":{"terms":["brand","mark","register","trademark"]},"styles":["solid","regular"],"unicode":"f1f9","label":"Copyright","free":["solid","regular"],"class":"copyright"},{"search":{"terms":["chair","cushion","furniture","relax","sofa"]},"styles":["solid"],"unicode":"f4b8","label":"Couch","free":["solid"],"class":"couch"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f388","label":"cPanel","free":["brands"],"class":"cpanel"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f25e","label":"Creative Commons","free":["brands"],"class":"creative-commons"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4e7","label":"Creative Commons Attribution","free":["brands"],"class":"creative-commons-by"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4e8","label":"Creative Commons Noncommercial","free":["brands"],"class":"creative-commons-nc"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4e9","label":"Creative Commons Noncommercial (Euro Sign)","free":["brands"],"class":"creative-commons-nc-eu"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4ea","label":"Creative Commons Noncommercial (Yen Sign)","free":["brands"],"class":"creative-commons-nc-jp"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4eb","label":"Creative Commons No Derivative Works","free":["brands"],"class":"creative-commons-nd"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4ec","label":"Creative Commons Public Domain","free":["brands"],"class":"creative-commons-pd"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4ed","label":"Alternate Creative Commons Public Domain","free":["brands"],"class":"creative-commons-pd-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4ee","label":"Creative Commons Remix","free":["brands"],"class":"creative-commons-remix"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4ef","label":"Creative Commons Share Alike","free":["brands"],"class":"creative-commons-sa"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f0","label":"Creative Commons Sampling","free":["brands"],"class":"creative-commons-sampling"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f1","label":"Creative Commons Sampling +","free":["brands"],"class":"creative-commons-sampling-plus"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f2","label":"Creative Commons Share","free":["brands"],"class":"creative-commons-share"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f3","label":"Creative Commons CC0","free":["brands"],"class":"creative-commons-zero"},{"search":{"terms":["buy","checkout","credit-card-alt","debit","money","payment","purchase"]},"styles":["solid","regular"],"unicode":"f09d","label":"Credit Card","free":["solid","regular"],"class":"credit-card"},{"search":{"terms":["Dungeons & Dragons","d&d","dnd","fantasy","game","gaming","tabletop"]},"styles":["brands"],"unicode":"f6c9","label":"Critical Role","free":["brands"],"class":"critical-role"},{"search":{"terms":["design","frame","mask","resize","shrink"]},"styles":["solid"],"unicode":"f125","label":"crop","free":["solid"],"class":"crop"},{"search":{"terms":["design","frame","mask","resize","shrink"]},"styles":["solid"],"unicode":"f565","label":"Alternate Crop","free":["solid"],"class":"crop-alt"},{"search":{"terms":["catholicism","christianity","church","jesus"]},"styles":["solid"],"unicode":"f654","label":"Cross","free":["solid"],"class":"cross"},{"search":{"terms":["aim","bullseye","gpd","picker","position"]},"styles":["solid"],"unicode":"f05b","label":"Crosshairs","free":["solid"],"class":"crosshairs"},{"search":{"terms":["bird","bullfrog","fauna","halloween","holiday","toad"]},"styles":["solid"],"unicode":"f520","label":"Crow","free":["solid"],"class":"crow"},{"search":{"terms":["award","favorite","king","queen","royal","tiara"]},"styles":["solid"],"unicode":"f521","label":"Crown","free":["solid"],"class":"crown"},{"search":{"terms":["cane","injury","mobility","wheelchair"]},"styles":["solid"],"unicode":"f7f7","label":"Crutch","free":["solid"],"class":"crutch"},{"search":{"terms":["code"]},"styles":["brands"],"unicode":"f13c","label":"CSS 3 Logo","free":["brands"],"class":"css3"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f38b","label":"Alternate CSS3 Logo","free":["brands"],"class":"css3-alt"},{"search":{"terms":["3d","block","dice","package","square","tesseract"]},"styles":["solid"],"unicode":"f1b2","label":"Cube","free":["solid"],"class":"cube"},{"search":{"terms":["3d","block","dice","package","pyramid","square","stack","tesseract"]},"styles":["solid"],"unicode":"f1b3","label":"Cubes","free":["solid"],"class":"cubes"},{"search":{"terms":["clip","scissors","snip"]},"styles":["solid"],"unicode":"f0c4","label":"Cut","free":["solid"],"class":"cut"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f38c","label":"Cuttlefish","free":["brands"],"class":"cuttlefish"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f38d","label":"Dungeons & Dragons","free":["brands"],"class":"d-and-d"},{"search":{"terms":["Dungeons & Dragons","d&d","dnd","fantasy","gaming","tabletop"]},"styles":["brands"],"unicode":"f6ca","label":"D&D Beyond","free":["brands"],"class":"d-and-d-beyond"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f210","label":"DashCube","free":["brands"],"class":"dashcube"},{"search":{"terms":["computer","development","directory","memory","storage"]},"styles":["solid"],"unicode":"f1c0","label":"Database","free":["solid"],"class":"database"},{"search":{"terms":["ear","hearing","sign language"]},"styles":["solid"],"unicode":"f2a4","label":"Deaf","free":["solid"],"class":"deaf"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a5","label":"Delicious","free":["brands"],"class":"delicious"},{"search":{"terms":["american","democratic party","donkey","election","left","left-wing","liberal","politics","usa"]},"styles":["solid"],"unicode":"f747","label":"Democrat","free":["solid"],"class":"democrat"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f38e","label":"deploy.dog","free":["brands"],"class":"deploydog"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f38f","label":"Deskpro","free":["brands"],"class":"deskpro"},{"search":{"terms":["computer","cpu","demo","desktop","device","imac","machine","monitor","pc","screen"]},"styles":["solid"],"unicode":"f108","label":"Desktop","free":["solid"],"class":"desktop"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f6cc","label":"DEV","free":["brands"],"class":"dev"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1bd","label":"deviantART","free":["brands"],"class":"deviantart"},{"search":{"terms":["buddhism","buddhist","wheel of dharma"]},"styles":["solid"],"unicode":"f655","label":"Dharmachakra","free":["solid"],"class":"dharmachakra"},{"search":{"terms":["Dalsey","Hillblom and Lynn","german","package","shipping"]},"styles":["brands"],"unicode":"f790","label":"DHL","free":["brands"],"class":"dhl"},{"search":{"terms":["analyze","detect","diagnosis","examine","medicine"]},"styles":["solid"],"unicode":"f470","label":"Diagnoses","free":["solid"],"class":"diagnoses"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f791","label":"Diaspora","free":["brands"],"class":"diaspora"},{"search":{"terms":["chance","gambling","game","roll"]},"styles":["solid"],"unicode":"f522","label":"Dice","free":["solid"],"class":"dice"},{"search":{"terms":["Dungeons & Dragons","chance","d&d","dnd","fantasy","gambling","game","roll"]},"styles":["solid"],"unicode":"f6cf","label":"Dice D20","free":["solid"],"class":"dice-d20"},{"search":{"terms":["Dungeons & Dragons","chance","d&d","dnd","fantasy","gambling","game","roll"]},"styles":["solid"],"unicode":"f6d1","label":"Dice D6","free":["solid"],"class":"dice-d6"},{"search":{"terms":["chance","gambling","game","roll"]},"styles":["solid"],"unicode":"f523","label":"Dice Five","free":["solid"],"class":"dice-five"},{"search":{"terms":["chance","gambling","game","roll"]},"styles":["solid"],"unicode":"f524","label":"Dice Four","free":["solid"],"class":"dice-four"},{"search":{"terms":["chance","gambling","game","roll"]},"styles":["solid"],"unicode":"f525","label":"Dice One","free":["solid"],"class":"dice-one"},{"search":{"terms":["chance","gambling","game","roll"]},"styles":["solid"],"unicode":"f526","label":"Dice Six","free":["solid"],"class":"dice-six"},{"search":{"terms":["chance","gambling","game","roll"]},"styles":["solid"],"unicode":"f527","label":"Dice Three","free":["solid"],"class":"dice-three"},{"search":{"terms":["chance","gambling","game","roll"]},"styles":["solid"],"unicode":"f528","label":"Dice Two","free":["solid"],"class":"dice-two"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a6","label":"Digg Logo","free":["brands"],"class":"digg"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f391","label":"Digital Ocean","free":["brands"],"class":"digital-ocean"},{"search":{"terms":["data","distance","speed","tachometer"]},"styles":["solid"],"unicode":"f566","label":"Digital Tachograph","free":["solid"],"class":"digital-tachograph"},{"search":{"terms":["map","navigation","sign","turn"]},"styles":["solid"],"unicode":"f5eb","label":"Directions","free":["solid"],"class":"directions"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f392","label":"Discord","free":["brands"],"class":"discord"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f393","label":"Discourse","free":["brands"],"class":"discourse"},{"search":{"terms":["arithmetic","calculus","division","math"]},"styles":["solid"],"unicode":"f529","label":"Divide","free":["solid"],"class":"divide"},{"search":{"terms":["dazed","dead","disapprove","emoticon","face"]},"styles":["solid","regular"],"unicode":"f567","label":"Dizzy Face","free":["solid","regular"],"class":"dizzy"},{"search":{"terms":["double helix","genetic","helix","molecule","protein"]},"styles":["solid"],"unicode":"f471","label":"DNA","free":["solid"],"class":"dna"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f394","label":"DocHub","free":["brands"],"class":"dochub"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f395","label":"Docker","free":["brands"],"class":"docker"},{"search":{"terms":["animal","canine","fauna","mammal","pet","pooch","puppy","woof"]},"styles":["solid"],"unicode":"f6d3","label":"Dog","free":["solid"],"class":"dog"},{"search":{"terms":["$","cost","dollar-sign","money","price","usd"]},"styles":["solid"],"unicode":"f155","label":"Dollar Sign","free":["solid"],"class":"dollar-sign"},{"search":{"terms":["carry","shipping","transport"]},"styles":["solid"],"unicode":"f472","label":"Dolly","free":["solid"],"class":"dolly"},{"search":{"terms":["carry","inventory","shipping","transport"]},"styles":["solid"],"unicode":"f474","label":"Dolly Flatbed","free":["solid"],"class":"dolly-flatbed"},{"search":{"terms":["contribute","generosity","gift","give"]},"styles":["solid"],"unicode":"f4b9","label":"Donate","free":["solid"],"class":"donate"},{"search":{"terms":["enter","exit","locked"]},"styles":["solid"],"unicode":"f52a","label":"Door Closed","free":["solid"],"class":"door-closed"},{"search":{"terms":["enter","exit","welcome"]},"styles":["solid"],"unicode":"f52b","label":"Door Open","free":["solid"],"class":"door-open"},{"search":{"terms":["bullseye","notification","target"]},"styles":["solid","regular"],"unicode":"f192","label":"Dot Circle","free":["solid","regular"],"class":"dot-circle"},{"search":{"terms":["bird","fauna","flying","peace","war"]},"styles":["solid"],"unicode":"f4ba","label":"Dove","free":["solid"],"class":"dove"},{"search":{"terms":["export","hard drive","save","transfer"]},"styles":["solid"],"unicode":"f019","label":"Download","free":["solid"],"class":"download"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f396","label":"Draft2digital","free":["brands"],"class":"draft2digital"},{"search":{"terms":["design","map","mechanical drawing","plot","plotting"]},"styles":["solid"],"unicode":"f568","label":"Drafting Compass","free":["solid"],"class":"drafting-compass"},{"search":{"terms":["Dungeons & Dragons","d&d","dnd","fantasy","fire","lizard","serpent"]},"styles":["solid"],"unicode":"f6d5","label":"Dragon","free":["solid"],"class":"dragon"},{"search":{"terms":["anchors","lines","object","render","shape"]},"styles":["solid"],"unicode":"f5ee","label":"Draw Polygon","free":["solid"],"class":"draw-polygon"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f17d","label":"Dribbble","free":["brands"],"class":"dribbble"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f397","label":"Dribbble Square","free":["brands"],"class":"dribbble-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f16b","label":"Dropbox","free":["brands"],"class":"dropbox"},{"search":{"terms":["instrument","music","percussion","snare","sound"]},"styles":["solid"],"unicode":"f569","label":"Drum","free":["solid"],"class":"drum"},{"search":{"terms":["calypso","instrument","music","percussion","reggae","snare","sound","steel","tropical"]},"styles":["solid"],"unicode":"f56a","label":"Drum Steelpan","free":["solid"],"class":"drum-steelpan"},{"search":{"terms":["bone","chicken","leg","meat","poultry","turkey"]},"styles":["solid"],"unicode":"f6d7","label":"Drumstick with Bite Taken Out","free":["solid"],"class":"drumstick-bite"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a9","label":"Drupal Logo","free":["brands"],"class":"drupal"},{"search":{"terms":["exercise","gym","strength","weight","weight-lifting"]},"styles":["solid"],"unicode":"f44b","label":"Dumbbell","free":["solid"],"class":"dumbbell"},{"search":{"terms":["alley","bin","commercial","trash","waste"]},"styles":["solid"],"unicode":"f793","label":"Dumpster","free":["solid"],"class":"dumpster"},{"search":{"terms":["alley","bin","commercial","danger","dangerous","euphemism","flame","heat","hot","trash","waste"]},"styles":["solid"],"unicode":"f794","label":"Dumpster Fire","free":["solid"],"class":"dumpster-fire"},{"search":{"terms":["Dungeons & Dragons","building","d&d","dnd","door","entrance","fantasy","gate"]},"styles":["solid"],"unicode":"f6d9","label":"Dungeon","free":["solid"],"class":"dungeon"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f399","label":"Dyalog","free":["brands"],"class":"dyalog"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f39a","label":"Earlybirds","free":["brands"],"class":"earlybirds"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f4","label":"eBay","free":["brands"],"class":"ebay"},{"search":{"terms":["browser","ie"]},"styles":["brands"],"unicode":"f282","label":"Edge Browser","free":["brands"],"class":"edge"},{"search":{"terms":["edit","pen","pencil","update","write"]},"styles":["solid","regular"],"unicode":"f044","label":"Edit","free":["solid","regular"],"class":"edit"},{"search":{"terms":["breakfast","chicken","easter","shell","yolk"]},"styles":["solid"],"unicode":"f7fb","label":"Egg","free":["solid"],"class":"egg"},{"search":{"terms":["abort","cancel","cd","discharge"]},"styles":["solid"],"unicode":"f052","label":"eject","free":["solid"],"class":"eject"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f430","label":"Elementor","free":["brands"],"class":"elementor"},{"search":{"terms":["dots","drag","kebab","list","menu","nav","navigation","ol","reorder","settings","ul"]},"styles":["solid"],"unicode":"f141","label":"Horizontal Ellipsis","free":["solid"],"class":"ellipsis-h"},{"search":{"terms":["dots","drag","kebab","list","menu","nav","navigation","ol","reorder","settings","ul"]},"styles":["solid"],"unicode":"f142","label":"Vertical Ellipsis","free":["solid"],"class":"ellipsis-v"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5f1","label":"Ello","free":["brands"],"class":"ello"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f423","label":"Ember","free":["brands"],"class":"ember"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1d1","label":"Galactic Empire","free":["brands"],"class":"empire"},{"search":{"terms":["e-mail","email","letter","mail","message","notification","support"]},"styles":["solid","regular"],"unicode":"f0e0","label":"Envelope","free":["solid","regular"],"class":"envelope"},{"search":{"terms":["e-mail","email","letter","mail","message","notification","support"]},"styles":["solid","regular"],"unicode":"f2b6","label":"Envelope Open","free":["solid","regular"],"class":"envelope-open"},{"search":{"terms":["e-mail","email","letter","mail","message","notification","support"]},"styles":["solid"],"unicode":"f658","label":"Envelope Open-text","free":["solid"],"class":"envelope-open-text"},{"search":{"terms":["e-mail","email","letter","mail","message","notification","support"]},"styles":["solid"],"unicode":"f199","label":"Envelope Square","free":["solid"],"class":"envelope-square"},{"search":{"terms":["leaf"]},"styles":["brands"],"unicode":"f299","label":"Envira Gallery","free":["brands"],"class":"envira"},{"search":{"terms":["arithmetic","even","match","math"]},"styles":["solid"],"unicode":"f52c","label":"Equals","free":["solid"],"class":"equals"},{"search":{"terms":["art","delete","remove","rubber"]},"styles":["solid"],"unicode":"f12d","label":"eraser","free":["solid"],"class":"eraser"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f39d","label":"Erlang","free":["brands"],"class":"erlang"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f42e","label":"Ethereum","free":["brands"],"class":"ethereum"},{"search":{"terms":["cable","cat 5","cat 6","connection","hardware","internet","network","wired"]},"styles":["solid"],"unicode":"f796","label":"Ethernet","free":["solid"],"class":"ethernet"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2d7","label":"Etsy","free":["brands"],"class":"etsy"},{"search":{"terms":["currency","dollar","exchange","money"]},"styles":["solid"],"unicode":"f153","label":"Euro Sign","free":["solid"],"class":"euro-sign"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f839","label":"Evernote","free":["brands"],"class":"evernote"},{"search":{"terms":["arrow","arrows","exchange","reciprocate","return","swap","transfer"]},"styles":["solid"],"unicode":"f362","label":"Alternate Exchange","free":["solid"],"class":"exchange-alt"},{"search":{"terms":["alert","danger","error","important","notice","notification","notify","problem","warning"]},"styles":["solid"],"unicode":"f12a","label":"exclamation","free":["solid"],"class":"exclamation"},{"search":{"terms":["alert","danger","error","important","notice","notification","notify","problem","warning"]},"styles":["solid"],"unicode":"f06a","label":"Exclamation Circle","free":["solid"],"class":"exclamation-circle"},{"search":{"terms":["alert","danger","error","important","notice","notification","notify","problem","warning"]},"styles":["solid"],"unicode":"f071","label":"Exclamation Triangle","free":["solid"],"class":"exclamation-triangle"},{"search":{"terms":["arrow","bigger","enlarge","resize"]},"styles":["solid"],"unicode":"f065","label":"Expand","free":["solid"],"class":"expand"},{"search":{"terms":["arrows-alt","bigger","enlarge","move","resize"]},"styles":["solid"],"unicode":"f31e","label":"Alternate Expand Arrows","free":["solid"],"class":"expand-arrows-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f23e","label":"ExpeditedSSL","free":["brands"],"class":"expeditedssl"},{"search":{"terms":["external-link","new","open","share"]},"styles":["solid"],"unicode":"f35d","label":"Alternate External Link","free":["solid"],"class":"external-link-alt"},{"search":{"terms":["external-link-square","new","open","share"]},"styles":["solid"],"unicode":"f360","label":"Alternate External Link Square","free":["solid"],"class":"external-link-square-alt"},{"search":{"terms":["look","optic","see","seen","show","sight","views","visible"]},"styles":["solid","regular"],"unicode":"f06e","label":"Eye","free":["solid","regular"],"class":"eye"},{"search":{"terms":["beaker","clone","color","copy","eyedropper","pipette"]},"styles":["solid"],"unicode":"f1fb","label":"Eye Dropper","free":["solid"],"class":"eye-dropper"},{"search":{"terms":["blind","hide","show","toggle","unseen","views","visible","visiblity"]},"styles":["solid","regular"],"unicode":"f070","label":"Eye Slash","free":["solid","regular"],"class":"eye-slash"},{"search":{"terms":["facebook-official","social network"]},"styles":["brands"],"unicode":"f09a","label":"Facebook","free":["brands"],"class":"facebook"},{"search":{"terms":["facebook"]},"styles":["brands"],"unicode":"f39e","label":"Facebook F","free":["brands"],"class":"facebook-f"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f39f","label":"Facebook Messenger","free":["brands"],"class":"facebook-messenger"},{"search":{"terms":["social network"]},"styles":["brands"],"unicode":"f082","label":"Facebook Square","free":["brands"],"class":"facebook-square"},{"search":{"terms":["ac","air conditioning","blade","blower","cool","hot"]},"styles":["solid"],"unicode":"f863","label":"Fan","free":["solid"],"class":"fan"},{"search":{"terms":["Dungeons & Dragons","d&d","dnd","fantasy","game","gaming","tabletop"]},"styles":["brands"],"unicode":"f6dc","label":"Fantasy Flight-games","free":["brands"],"class":"fantasy-flight-games"},{"search":{"terms":["beginning","first","previous","rewind","start"]},"styles":["solid"],"unicode":"f049","label":"fast-backward","free":["solid"],"class":"fast-backward"},{"search":{"terms":["end","last","next"]},"styles":["solid"],"unicode":"f050","label":"fast-forward","free":["solid"],"class":"fast-forward"},{"search":{"terms":["business","communicate","copy","facsimile","send"]},"styles":["solid"],"unicode":"f1ac","label":"Fax","free":["solid"],"class":"fax"},{"search":{"terms":["bird","light","plucked","quill","write"]},"styles":["solid"],"unicode":"f52d","label":"Feather","free":["solid"],"class":"feather"},{"search":{"terms":["bird","light","plucked","quill","write"]},"styles":["solid"],"unicode":"f56b","label":"Alternate Feather","free":["solid"],"class":"feather-alt"},{"search":{"terms":["Federal Express","package","shipping"]},"styles":["brands"],"unicode":"f797","label":"FedEx","free":["brands"],"class":"fedex"},{"search":{"terms":["linux","operating system","os"]},"styles":["brands"],"unicode":"f798","label":"Fedora","free":["brands"],"class":"fedora"},{"search":{"terms":["human","person","profile","user","woman"]},"styles":["solid"],"unicode":"f182","label":"Female","free":["solid"],"class":"female"},{"search":{"terms":["airplane","fast","fly","goose","maverick","plane","quick","top gun","transportation","travel"]},"styles":["solid"],"unicode":"f0fb","label":"fighter-jet","free":["solid"],"class":"fighter-jet"},{"search":{"terms":["app","design","interface"]},"styles":["brands"],"unicode":"f799","label":"Figma","free":["brands"],"class":"figma"},{"search":{"terms":["document","new","page","pdf","resume"]},"styles":["solid","regular"],"unicode":"f15b","label":"File","free":["solid","regular"],"class":"file"},{"search":{"terms":["document","file-text","invoice","new","page","pdf"]},"styles":["solid","regular"],"unicode":"f15c","label":"Alternate File","free":["solid","regular"],"class":"file-alt"},{"search":{"terms":[".zip","bundle","compress","compression","download","zip"]},"styles":["solid","regular"],"unicode":"f1c6","label":"Archive File","free":["solid","regular"],"class":"file-archive"},{"search":{"terms":["document","mp3","music","page","play","sound"]},"styles":["solid","regular"],"unicode":"f1c7","label":"Audio File","free":["solid","regular"],"class":"file-audio"},{"search":{"terms":["css","development","document","html"]},"styles":["solid","regular"],"unicode":"f1c9","label":"Code File","free":["solid","regular"],"class":"file-code"},{"search":{"terms":["agreement","binding","document","legal","signature"]},"styles":["solid"],"unicode":"f56c","label":"File Contract","free":["solid"],"class":"file-contract"},{"search":{"terms":["document","excel","numbers","spreadsheets","table"]},"styles":["solid"],"unicode":"f6dd","label":"File CSV","free":["solid"],"class":"file-csv"},{"search":{"terms":["document","export","save"]},"styles":["solid"],"unicode":"f56d","label":"File Download","free":["solid"],"class":"file-download"},{"search":{"terms":["csv","document","numbers","spreadsheets","table"]},"styles":["solid","regular"],"unicode":"f1c3","label":"Excel File","free":["solid","regular"],"class":"file-excel"},{"search":{"terms":["download","save"]},"styles":["solid"],"unicode":"f56e","label":"File Export","free":["solid"],"class":"file-export"},{"search":{"terms":["document","image","jpg","photo","png"]},"styles":["solid","regular"],"unicode":"f1c5","label":"Image File","free":["solid","regular"],"class":"file-image"},{"search":{"terms":["copy","document","send","upload"]},"styles":["solid"],"unicode":"f56f","label":"File Import","free":["solid"],"class":"file-import"},{"search":{"terms":["account","bill","charge","document","payment","receipt"]},"styles":["solid"],"unicode":"f570","label":"File Invoice","free":["solid"],"class":"file-invoice"},{"search":{"terms":["$","account","bill","charge","document","dollar-sign","money","payment","receipt","usd"]},"styles":["solid"],"unicode":"f571","label":"File Invoice with US Dollar","free":["solid"],"class":"file-invoice-dollar"},{"search":{"terms":["document","health","history","prescription","record"]},"styles":["solid"],"unicode":"f477","label":"Medical File","free":["solid"],"class":"file-medical"},{"search":{"terms":["document","health","history","prescription","record"]},"styles":["solid"],"unicode":"f478","label":"Alternate Medical File","free":["solid"],"class":"file-medical-alt"},{"search":{"terms":["acrobat","document","preview","save"]},"styles":["solid","regular"],"unicode":"f1c1","label":"PDF File","free":["solid","regular"],"class":"file-pdf"},{"search":{"terms":["display","document","keynote","presentation"]},"styles":["solid","regular"],"unicode":"f1c4","label":"Powerpoint File","free":["solid","regular"],"class":"file-powerpoint"},{"search":{"terms":["document","drugs","medical","medicine","rx"]},"styles":["solid"],"unicode":"f572","label":"File Prescription","free":["solid"],"class":"file-prescription"},{"search":{"terms":["John Hancock","contract","document","name"]},"styles":["solid"],"unicode":"f573","label":"File Signature","free":["solid"],"class":"file-signature"},{"search":{"terms":["document","import","page","save"]},"styles":["solid"],"unicode":"f574","label":"File Upload","free":["solid"],"class":"file-upload"},{"search":{"terms":["document","m4v","movie","mp4","play"]},"styles":["solid","regular"],"unicode":"f1c8","label":"Video File","free":["solid","regular"],"class":"file-video"},{"search":{"terms":["document","edit","page","text","writing"]},"styles":["solid","regular"],"unicode":"f1c2","label":"Word File","free":["solid","regular"],"class":"file-word"},{"search":{"terms":["bucket","color","paint","paint bucket"]},"styles":["solid"],"unicode":"f575","label":"Fill","free":["solid"],"class":"fill"},{"search":{"terms":["bucket","color","drop","paint","paint bucket","spill"]},"styles":["solid"],"unicode":"f576","label":"Fill Drip","free":["solid"],"class":"fill-drip"},{"search":{"terms":["cinema","movie","strip","video"]},"styles":["solid"],"unicode":"f008","label":"Film","free":["solid"],"class":"film"},{"search":{"terms":["funnel","options","separate","sort"]},"styles":["solid"],"unicode":"f0b0","label":"Filter","free":["solid"],"class":"filter"},{"search":{"terms":["human","id","identification","lock","smudge","touch","unique","unlock"]},"styles":["solid"],"unicode":"f577","label":"Fingerprint","free":["solid"],"class":"fingerprint"},{"search":{"terms":["burn","caliente","flame","heat","hot","popular"]},"styles":["solid"],"unicode":"f06d","label":"fire","free":["solid"],"class":"fire"},{"search":{"terms":["burn","caliente","flame","heat","hot","popular"]},"styles":["solid"],"unicode":"f7e4","label":"Alternate Fire","free":["solid"],"class":"fire-alt"},{"search":{"terms":["burn","caliente","fire fighter","flame","heat","hot","rescue"]},"styles":["solid"],"unicode":"f134","label":"fire-extinguisher","free":["solid"],"class":"fire-extinguisher"},{"search":{"terms":["browser"]},"styles":["brands"],"unicode":"f269","label":"Firefox","free":["brands"],"class":"firefox"},{"search":{"terms":["emergency","emt","health","medical","rescue"]},"styles":["solid"],"unicode":"f479","label":"First Aid","free":["solid"],"class":"first-aid"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2b0","label":"First Order","free":["brands"],"class":"first-order"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f50a","label":"Alternate First Order","free":["brands"],"class":"first-order-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3a1","label":"firstdraft","free":["brands"],"class":"firstdraft"},{"search":{"terms":["fauna","gold","seafood","swimming"]},"styles":["solid"],"unicode":"f578","label":"Fish","free":["solid"],"class":"fish"},{"search":{"terms":["Dungeons & Dragons","d&d","dnd","fantasy","hand","ki","monk","resist","strength","unarmed combat"]},"styles":["solid"],"unicode":"f6de","label":"Raised Fist","free":["solid"],"class":"fist-raised"},{"search":{"terms":["country","notice","notification","notify","pole","report","symbol"]},"styles":["solid","regular"],"unicode":"f024","label":"flag","free":["solid","regular"],"class":"flag"},{"search":{"terms":["notice","notification","notify","pole","racing","report","symbol"]},"styles":["solid"],"unicode":"f11e","label":"flag-checkered","free":["solid"],"class":"flag-checkered"},{"search":{"terms":["betsy ross","country","old glory","stars","stripes","symbol"]},"styles":["solid"],"unicode":"f74d","label":"United States of America Flag","free":["solid"],"class":"flag-usa"},{"search":{"terms":["beaker","experimental","labs","science"]},"styles":["solid"],"unicode":"f0c3","label":"Flask","free":["solid"],"class":"flask"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f16e","label":"Flickr","free":["brands"],"class":"flickr"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f44d","label":"Flipboard","free":["brands"],"class":"flipboard"},{"search":{"terms":["embarrassed","emoticon","face"]},"styles":["solid","regular"],"unicode":"f579","label":"Flushed Face","free":["solid","regular"],"class":"flushed"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f417","label":"Fly","free":["brands"],"class":"fly"},{"search":{"terms":["archive","directory","document","file"]},"styles":["solid","regular"],"unicode":"f07b","label":"Folder","free":["solid","regular"],"class":"folder"},{"search":{"terms":["archive","delete","directory","document","file","negative","remove"]},"styles":["solid"],"unicode":"f65d","label":"Folder Minus","free":["solid"],"class":"folder-minus"},{"search":{"terms":["archive","directory","document","empty","file","new"]},"styles":["solid","regular"],"unicode":"f07c","label":"Folder Open","free":["solid","regular"],"class":"folder-open"},{"search":{"terms":["add","archive","create","directory","document","file","new","positive"]},"styles":["solid"],"unicode":"f65e","label":"Folder Plus","free":["solid"],"class":"folder-plus"},{"search":{"terms":["alphabet","glyph","text","type","typeface"]},"styles":["solid"],"unicode":"f031","label":"font","free":["solid"],"class":"font"},{"search":{"terms":["meanpath"]},"styles":["brands"],"unicode":"f2b4","label":"Font Awesome","free":["brands"],"class":"font-awesome"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f35c","label":"Alternate Font Awesome","free":["brands"],"class":"font-awesome-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f425","label":"Font Awesome Flag","free":["brands"],"class":"font-awesome-flag"},{"search":{"terms":[]},"styles":["regular","solid","brands"],"unicode":"f4e6","label":"Font Awesome Full Logo","private":true,"free":["regular","solid","brands"],"class":"font-awesome-logo-full"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f280","label":"Fonticons","free":["brands"],"class":"fonticons"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3a2","label":"Fonticons Fi","free":["brands"],"class":"fonticons-fi"},{"search":{"terms":["ball","fall","nfl","pigskin","seasonal"]},"styles":["solid"],"unicode":"f44e","label":"Football Ball","free":["solid"],"class":"football-ball"},{"search":{"terms":["castle"]},"styles":["brands"],"unicode":"f286","label":"Fort Awesome","free":["brands"],"class":"fort-awesome"},{"search":{"terms":["castle"]},"styles":["brands"],"unicode":"f3a3","label":"Alternate Fort Awesome","free":["brands"],"class":"fort-awesome-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f211","label":"Forumbee","free":["brands"],"class":"forumbee"},{"search":{"terms":["forward","next","skip"]},"styles":["solid"],"unicode":"f04e","label":"forward","free":["solid"],"class":"forward"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f180","label":"Foursquare","free":["brands"],"class":"foursquare"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2c5","label":"Free Code Camp","free":["brands"],"class":"free-code-camp"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3a4","label":"FreeBSD","free":["brands"],"class":"freebsd"},{"search":{"terms":["amphibian","bullfrog","fauna","hop","kermit","kiss","prince","ribbit","toad","wart"]},"styles":["solid"],"unicode":"f52e","label":"Frog","free":["solid"],"class":"frog"},{"search":{"terms":["disapprove","emoticon","face","rating","sad"]},"styles":["solid","regular"],"unicode":"f119","label":"Frowning Face","free":["solid","regular"],"class":"frown"},{"search":{"terms":["disapprove","emoticon","face","rating","sad"]},"styles":["solid","regular"],"unicode":"f57a","label":"Frowning Face With Open Mouth","free":["solid","regular"],"class":"frown-open"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f50b","label":"Fulcrum","free":["brands"],"class":"fulcrum"},{"search":{"terms":["filter","money","options","separate","sort"]},"styles":["solid"],"unicode":"f662","label":"Funnel Dollar","free":["solid"],"class":"funnel-dollar"},{"search":{"terms":["ball","football","mls","soccer"]},"styles":["solid","regular"],"unicode":"f1e3","label":"Futbol","free":["solid","regular"],"class":"futbol"},{"search":{"terms":["politics","star wars"]},"styles":["brands"],"unicode":"f50c","label":"Galactic Republic","free":["brands"],"class":"galactic-republic"},{"search":{"terms":["star wars"]},"styles":["brands"],"unicode":"f50d","label":"Galactic Senate","free":["brands"],"class":"galactic-senate"},{"search":{"terms":["controller","d-pad","joystick","video"]},"styles":["solid"],"unicode":"f11b","label":"Gamepad","free":["solid"],"class":"gamepad"},{"search":{"terms":["car","fuel","gasoline","petrol"]},"styles":["solid"],"unicode":"f52f","label":"Gas Pump","free":["solid"],"class":"gas-pump"},{"search":{"terms":["hammer","judge","law","lawyer","opinion"]},"styles":["solid"],"unicode":"f0e3","label":"Gavel","free":["solid"],"class":"gavel"},{"search":{"terms":["diamond","jewelry","sapphire","stone","treasure"]},"styles":["solid","regular"],"unicode":"f3a5","label":"Gem","free":["solid","regular"],"class":"gem"},{"search":{"terms":["androgynous","asexual","sexless"]},"styles":["solid"],"unicode":"f22d","label":"Genderless","free":["solid"],"class":"genderless"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f265","label":"Get Pocket","free":["brands"],"class":"get-pocket"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f260","label":"GG Currency","free":["brands"],"class":"gg"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f261","label":"GG Currency Circle","free":["brands"],"class":"gg-circle"},{"search":{"terms":["apparition","blinky","clyde","floating","halloween","holiday","inky","pinky","spirit"]},"styles":["solid"],"unicode":"f6e2","label":"Ghost","free":["solid"],"class":"ghost"},{"search":{"terms":["christmas","generosity","giving","holiday","party","present","wrapped","xmas"]},"styles":["solid"],"unicode":"f06b","label":"gift","free":["solid"],"class":"gift"},{"search":{"terms":["christmas","generosity","giving","holiday","party","present","wrapped","xmas"]},"styles":["solid"],"unicode":"f79c","label":"Gifts","free":["solid"],"class":"gifts"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1d3","label":"Git","free":["brands"],"class":"git"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f841","label":"Git Alt","free":["brands"],"class":"git-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1d2","label":"Git Square","free":["brands"],"class":"git-square"},{"search":{"terms":["octocat"]},"styles":["brands"],"unicode":"f09b","label":"GitHub","free":["brands"],"class":"github"},{"search":{"terms":["octocat"]},"styles":["brands"],"unicode":"f113","label":"Alternate GitHub","free":["brands"],"class":"github-alt"},{"search":{"terms":["octocat"]},"styles":["brands"],"unicode":"f092","label":"GitHub Square","free":["brands"],"class":"github-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3a6","label":"GitKraken","free":["brands"],"class":"gitkraken"},{"search":{"terms":["Axosoft"]},"styles":["brands"],"unicode":"f296","label":"GitLab","free":["brands"],"class":"gitlab"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f426","label":"Gitter","free":["brands"],"class":"gitter"},{"search":{"terms":["alcohol","bar","beverage","celebration","champagne","clink","drink","holiday","new year's eve","party","toast"]},"styles":["solid"],"unicode":"f79f","label":"Glass Cheers","free":["solid"],"class":"glass-cheers"},{"search":{"terms":["alcohol","bar","beverage","drink","liquor"]},"styles":["solid"],"unicode":"f000","label":"Martini Glass","free":["solid"],"class":"glass-martini"},{"search":{"terms":["alcohol","bar","beverage","drink","liquor"]},"styles":["solid"],"unicode":"f57b","label":"Alternate Glass Martini","free":["solid"],"class":"glass-martini-alt"},{"search":{"terms":["alcohol","bar","beverage","bourbon","drink","liquor","neat","rye","scotch","whisky"]},"styles":["solid"],"unicode":"f7a0","label":"Glass Whiskey","free":["solid"],"class":"glass-whiskey"},{"search":{"terms":["hipster","nerd","reading","sight","spectacles","vision"]},"styles":["solid"],"unicode":"f530","label":"Glasses","free":["solid"],"class":"glasses"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2a5","label":"Glide","free":["brands"],"class":"glide"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2a6","label":"Glide G","free":["brands"],"class":"glide-g"},{"search":{"terms":["all","coordinates","country","earth","global","gps","language","localize","location","map","online","place","planet","translate","travel","world"]},"styles":["solid"],"unicode":"f0ac","label":"Globe","free":["solid"],"class":"globe"},{"search":{"terms":["all","country","earth","global","gps","language","localize","location","map","online","place","planet","translate","travel","world"]},"styles":["solid"],"unicode":"f57c","label":"Globe with Africa shown","free":["solid"],"class":"globe-africa"},{"search":{"terms":["all","country","earth","global","gps","language","localize","location","map","online","place","planet","translate","travel","world"]},"styles":["solid"],"unicode":"f57d","label":"Globe with Americas shown","free":["solid"],"class":"globe-americas"},{"search":{"terms":["all","country","earth","global","gps","language","localize","location","map","online","place","planet","translate","travel","world"]},"styles":["solid"],"unicode":"f57e","label":"Globe with Asia shown","free":["solid"],"class":"globe-asia"},{"search":{"terms":["all","country","earth","global","gps","language","localize","location","map","online","place","planet","translate","travel","world"]},"styles":["solid"],"unicode":"f7a2","label":"Globe with Europe shown","free":["solid"],"class":"globe-europe"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3a7","label":"Gofore","free":["brands"],"class":"gofore"},{"search":{"terms":["caddy","eagle","putt","tee"]},"styles":["solid"],"unicode":"f450","label":"Golf Ball","free":["solid"],"class":"golf-ball"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3a8","label":"Goodreads","free":["brands"],"class":"goodreads"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3a9","label":"Goodreads G","free":["brands"],"class":"goodreads-g"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a0","label":"Google Logo","free":["brands"],"class":"google"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3aa","label":"Google Drive","free":["brands"],"class":"google-drive"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ab","label":"Google Play","free":["brands"],"class":"google-play"},{"search":{"terms":["google-plus-circle","google-plus-official"]},"styles":["brands"],"unicode":"f2b3","label":"Google Plus","free":["brands"],"class":"google-plus"},{"search":{"terms":["google-plus","social network"]},"styles":["brands"],"unicode":"f0d5","label":"Google Plus G","free":["brands"],"class":"google-plus-g"},{"search":{"terms":["social network"]},"styles":["brands"],"unicode":"f0d4","label":"Google Plus Square","free":["brands"],"class":"google-plus-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1ee","label":"Google Wallet","free":["brands"],"class":"google-wallet"},{"search":{"terms":["building","entrance","hinduism","temple","tower"]},"styles":["solid"],"unicode":"f664","label":"Gopuram","free":["solid"],"class":"gopuram"},{"search":{"terms":["ceremony","college","graduate","learning","school","student"]},"styles":["solid"],"unicode":"f19d","label":"Graduation Cap","free":["solid"],"class":"graduation-cap"},{"search":{"terms":["favorite","heart","like","love"]},"styles":["brands"],"unicode":"f184","label":"Gratipay (Gittip)","free":["brands"],"class":"gratipay"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2d6","label":"Grav","free":["brands"],"class":"grav"},{"search":{"terms":["arithmetic","compare","math"]},"styles":["solid"],"unicode":"f531","label":"Greater Than","free":["solid"],"class":"greater-than"},{"search":{"terms":["arithmetic","compare","math"]},"styles":["solid"],"unicode":"f532","label":"Greater Than Equal To","free":["solid"],"class":"greater-than-equal"},{"search":{"terms":["cringe","emoticon","face","teeth"]},"styles":["solid","regular"],"unicode":"f57f","label":"Grimacing Face","free":["solid","regular"],"class":"grimace"},{"search":{"terms":["emoticon","face","laugh","smile"]},"styles":["solid","regular"],"unicode":"f580","label":"Grinning Face","free":["solid","regular"],"class":"grin"},{"search":{"terms":["emoticon","face","laugh","smile"]},"styles":["solid","regular"],"unicode":"f581","label":"Alternate Grinning Face","free":["solid","regular"],"class":"grin-alt"},{"search":{"terms":["emoticon","face","laugh","smile"]},"styles":["solid","regular"],"unicode":"f582","label":"Grinning Face With Smiling Eyes","free":["solid","regular"],"class":"grin-beam"},{"search":{"terms":["embarass","emoticon","face","smile"]},"styles":["solid","regular"],"unicode":"f583","label":"Grinning Face With Sweat","free":["solid","regular"],"class":"grin-beam-sweat"},{"search":{"terms":["emoticon","face","love","smile"]},"styles":["solid","regular"],"unicode":"f584","label":"Smiling Face With Heart-Eyes","free":["solid","regular"],"class":"grin-hearts"},{"search":{"terms":["emoticon","face","laugh","smile"]},"styles":["solid","regular"],"unicode":"f585","label":"Grinning Squinting Face","free":["solid","regular"],"class":"grin-squint"},{"search":{"terms":["emoticon","face","happy","smile"]},"styles":["solid","regular"],"unicode":"f586","label":"Rolling on the Floor Laughing","free":["solid","regular"],"class":"grin-squint-tears"},{"search":{"terms":["emoticon","face","star-struck"]},"styles":["solid","regular"],"unicode":"f587","label":"Star-Struck","free":["solid","regular"],"class":"grin-stars"},{"search":{"terms":["LOL","emoticon","face"]},"styles":["solid","regular"],"unicode":"f588","label":"Face With Tears of Joy","free":["solid","regular"],"class":"grin-tears"},{"search":{"terms":["LOL","emoticon","face"]},"styles":["solid","regular"],"unicode":"f589","label":"Face With Tongue","free":["solid","regular"],"class":"grin-tongue"},{"search":{"terms":["LOL","emoticon","face"]},"styles":["solid","regular"],"unicode":"f58a","label":"Squinting Face With Tongue","free":["solid","regular"],"class":"grin-tongue-squint"},{"search":{"terms":["LOL","emoticon","face"]},"styles":["solid","regular"],"unicode":"f58b","label":"Winking Face With Tongue","free":["solid","regular"],"class":"grin-tongue-wink"},{"search":{"terms":["emoticon","face","flirt","laugh","smile"]},"styles":["solid","regular"],"unicode":"f58c","label":"Grinning Winking Face","free":["solid","regular"],"class":"grin-wink"},{"search":{"terms":["affordance","drag","drop","grab","handle"]},"styles":["solid"],"unicode":"f58d","label":"Grip Horizontal","free":["solid"],"class":"grip-horizontal"},{"search":{"terms":["affordance","drag","drop","grab","handle"]},"styles":["solid"],"unicode":"f7a4","label":"Grip Lines","free":["solid"],"class":"grip-lines"},{"search":{"terms":["affordance","drag","drop","grab","handle"]},"styles":["solid"],"unicode":"f7a5","label":"Grip Lines Vertical","free":["solid"],"class":"grip-lines-vertical"},{"search":{"terms":["affordance","drag","drop","grab","handle"]},"styles":["solid"],"unicode":"f58e","label":"Grip Vertical","free":["solid"],"class":"grip-vertical"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ac","label":"Gripfire, Inc.","free":["brands"],"class":"gripfire"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ad","label":"Grunt","free":["brands"],"class":"grunt"},{"search":{"terms":["acoustic","instrument","music","rock","rock and roll","song","strings"]},"styles":["solid"],"unicode":"f7a6","label":"Guitar","free":["solid"],"class":"guitar"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ae","label":"Gulp","free":["brands"],"class":"gulp"},{"search":{"terms":["directions","emergency","hospital","hotel","map"]},"styles":["solid"],"unicode":"f0fd","label":"H Square","free":["solid"],"class":"h-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1d4","label":"Hacker News","free":["brands"],"class":"hacker-news"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3af","label":"Hacker News Square","free":["brands"],"class":"hacker-news-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5f7","label":"Hackerrank","free":["brands"],"class":"hackerrank"},{"search":{"terms":["bacon","beef","burger","burger king","cheeseburger","fast food","grill","ground beef","mcdonalds","sandwich"]},"styles":["solid"],"unicode":"f805","label":"Hamburger","free":["solid"],"class":"hamburger"},{"search":{"terms":["admin","fix","repair","settings","tool"]},"styles":["solid"],"unicode":"f6e3","label":"Hammer","free":["solid"],"class":"hammer"},{"search":{"terms":["amulet","christianity","islam","jewish","judaism","muslim","protection"]},"styles":["solid"],"unicode":"f665","label":"Hamsa","free":["solid"],"class":"hamsa"},{"search":{"terms":["carry","lift"]},"styles":["solid"],"unicode":"f4bd","label":"Hand Holding","free":["solid"],"class":"hand-holding"},{"search":{"terms":["carry","charity","gift","lift","package"]},"styles":["solid"],"unicode":"f4be","label":"Hand Holding Heart","free":["solid"],"class":"hand-holding-heart"},{"search":{"terms":["$","carry","dollar sign","donation","giving","lift","money","price"]},"styles":["solid"],"unicode":"f4c0","label":"Hand Holding US Dollar","free":["solid"],"class":"hand-holding-usd"},{"search":{"terms":["game","roshambo"]},"styles":["solid","regular"],"unicode":"f258","label":"Lizard (Hand)","free":["solid","regular"],"class":"hand-lizard"},{"search":{"terms":["flip the bird","gesture","hate","rude"]},"styles":["solid"],"unicode":"f806","label":"Hand with Middle Finger Raised","free":["solid"],"class":"hand-middle-finger"},{"search":{"terms":["game","halt","roshambo","stop"]},"styles":["solid","regular"],"unicode":"f256","label":"Paper (Hand)","free":["solid","regular"],"class":"hand-paper"},{"search":{"terms":["rest","truce"]},"styles":["solid","regular"],"unicode":"f25b","label":"Peace (Hand)","free":["solid","regular"],"class":"hand-peace"},{"search":{"terms":["finger","hand-o-down","point"]},"styles":["solid","regular"],"unicode":"f0a7","label":"Hand Pointing Down","free":["solid","regular"],"class":"hand-point-down"},{"search":{"terms":["back","finger","hand-o-left","left","point","previous"]},"styles":["solid","regular"],"unicode":"f0a5","label":"Hand Pointing Left","free":["solid","regular"],"class":"hand-point-left"},{"search":{"terms":["finger","forward","hand-o-right","next","point","right"]},"styles":["solid","regular"],"unicode":"f0a4","label":"Hand Pointing Right","free":["solid","regular"],"class":"hand-point-right"},{"search":{"terms":["finger","hand-o-up","point"]},"styles":["solid","regular"],"unicode":"f0a6","label":"Hand Pointing Up","free":["solid","regular"],"class":"hand-point-up"},{"search":{"terms":["arrow","cursor","select"]},"styles":["solid","regular"],"unicode":"f25a","label":"Pointer (Hand)","free":["solid","regular"],"class":"hand-pointer"},{"search":{"terms":["fist","game","roshambo"]},"styles":["solid","regular"],"unicode":"f255","label":"Rock (Hand)","free":["solid","regular"],"class":"hand-rock"},{"search":{"terms":["cut","game","roshambo"]},"styles":["solid","regular"],"unicode":"f257","label":"Scissors (Hand)","free":["solid","regular"],"class":"hand-scissors"},{"search":{"terms":["live long","prosper","salute","star trek","vulcan"]},"styles":["solid","regular"],"unicode":"f259","label":"Spock (Hand)","free":["solid","regular"],"class":"hand-spock"},{"search":{"terms":["carry","hold","lift"]},"styles":["solid"],"unicode":"f4c2","label":"Hands","free":["solid"],"class":"hands"},{"search":{"terms":["aid","assistance","handshake","partnership","volunteering"]},"styles":["solid"],"unicode":"f4c4","label":"Helping Hands","free":["solid"],"class":"hands-helping"},{"search":{"terms":["agreement","greeting","meeting","partnership"]},"styles":["solid","regular"],"unicode":"f2b5","label":"Handshake","free":["solid","regular"],"class":"handshake"},{"search":{"terms":["candle","hanukkah","jewish","judaism","light"]},"styles":["solid"],"unicode":"f6e6","label":"Hanukiah","free":["solid"],"class":"hanukiah"},{"search":{"terms":["construction","hardhat","helmet","safety"]},"styles":["solid"],"unicode":"f807","label":"Hard Hat","free":["solid"],"class":"hard-hat"},{"search":{"terms":["Twitter","instagram","pound","social media","tag"]},"styles":["solid"],"unicode":"f292","label":"Hashtag","free":["solid"],"class":"hashtag"},{"search":{"terms":["Dungeons & Dragons","accessory","buckle","clothing","d&d","dnd","fantasy","halloween","head","holiday","mage","magic","pointy","witch"]},"styles":["solid"],"unicode":"f6e8","label":"Wizard's Hat","free":["solid"],"class":"hat-wizard"},{"search":{"terms":["bahai","bahá'í","star"]},"styles":["solid"],"unicode":"f666","label":"Haykal","free":["solid"],"class":"haykal"},{"search":{"terms":["cpu","hard drive","harddrive","machine","save","storage"]},"styles":["solid","regular"],"unicode":"f0a0","label":"HDD","free":["solid","regular"],"class":"hdd"},{"search":{"terms":["format","header","text","title"]},"styles":["solid"],"unicode":"f1dc","label":"heading","free":["solid"],"class":"heading"},{"search":{"terms":["audio","listen","music","sound","speaker"]},"styles":["solid"],"unicode":"f025","label":"headphones","free":["solid"],"class":"headphones"},{"search":{"terms":["audio","listen","music","sound","speaker"]},"styles":["solid"],"unicode":"f58f","label":"Alternate Headphones","free":["solid"],"class":"headphones-alt"},{"search":{"terms":["audio","gamer","gaming","listen","live chat","microphone","shot caller","sound","support","telemarketer"]},"styles":["solid"],"unicode":"f590","label":"Headset","free":["solid"],"class":"headset"},{"search":{"terms":["favorite","like","love","relationship","valentine"]},"styles":["solid","regular"],"unicode":"f004","label":"Heart","free":["solid","regular"],"class":"heart"},{"search":{"terms":["breakup","crushed","dislike","dumped","grief","love","lovesick","relationship","sad"]},"styles":["solid"],"unicode":"f7a9","label":"Heart Broken","free":["solid"],"class":"heart-broken"},{"search":{"terms":["ekg","electrocardiogram","health","lifeline","vital signs"]},"styles":["solid"],"unicode":"f21e","label":"Heartbeat","free":["solid"],"class":"heartbeat"},{"search":{"terms":["airwolf","apache","chopper","flight","fly","travel"]},"styles":["solid"],"unicode":"f533","label":"Helicopter","free":["solid"],"class":"helicopter"},{"search":{"terms":["edit","marker","sharpie","update","write"]},"styles":["solid"],"unicode":"f591","label":"Highlighter","free":["solid"],"class":"highlighter"},{"search":{"terms":["activity","backpack","fall","fitness","outdoors","person","seasonal","walking"]},"styles":["solid"],"unicode":"f6ec","label":"Hiking","free":["solid"],"class":"hiking"},{"search":{"terms":["animal","fauna","hippopotamus","hungry","mammal"]},"styles":["solid"],"unicode":"f6ed","label":"Hippo","free":["solid"],"class":"hippo"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f452","label":"Hips","free":["brands"],"class":"hips"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b0","label":"HireAHelper","free":["brands"],"class":"hire-a-helper"},{"search":{"terms":["Rewind","clock","reverse","time","time machine"]},"styles":["solid"],"unicode":"f1da","label":"History","free":["solid"],"class":"history"},{"search":{"terms":["ice","nhl","sport"]},"styles":["solid"],"unicode":"f453","label":"Hockey Puck","free":["solid"],"class":"hockey-puck"},{"search":{"terms":["catwoman","christmas","decoration","flora","halle","holiday","ororo munroe","plant","storm","xmas"]},"styles":["solid"],"unicode":"f7aa","label":"Holly Berry","free":["solid"],"class":"holly-berry"},{"search":{"terms":["abode","building","house","main"]},"styles":["solid"],"unicode":"f015","label":"home","free":["solid"],"class":"home"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f427","label":"Hooli","free":["brands"],"class":"hooli"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f592","label":"Hornbill","free":["brands"],"class":"hornbill"},{"search":{"terms":["equus","fauna","mammmal","mare","neigh","pony"]},"styles":["solid"],"unicode":"f6f0","label":"Horse","free":["solid"],"class":"horse"},{"search":{"terms":["equus","fauna","mammmal","mare","neigh","pony"]},"styles":["solid"],"unicode":"f7ab","label":"Horse Head","free":["solid"],"class":"horse-head"},{"search":{"terms":["building","emergency room","medical center"]},"styles":["solid","regular"],"unicode":"f0f8","label":"hospital","free":["solid","regular"],"class":"hospital"},{"search":{"terms":["building","emergency room","medical center"]},"styles":["solid"],"unicode":"f47d","label":"Alternate Hospital","free":["solid"],"class":"hospital-alt"},{"search":{"terms":["clinic","emergency","map"]},"styles":["solid"],"unicode":"f47e","label":"Hospital Symbol","free":["solid"],"class":"hospital-symbol"},{"search":{"terms":["bath","jacuzzi","massage","sauna","spa"]},"styles":["solid"],"unicode":"f593","label":"Hot Tub","free":["solid"],"class":"hot-tub"},{"search":{"terms":["bun","chili","frankfurt","frankfurter","kosher","polish","sandwich","sausage","vienna","weiner"]},"styles":["solid"],"unicode":"f80f","label":"Hot Dog","free":["solid"],"class":"hotdog"},{"search":{"terms":["building","inn","lodging","motel","resort","travel"]},"styles":["solid"],"unicode":"f594","label":"Hotel","free":["solid"],"class":"hotel"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b1","label":"Hotjar","free":["brands"],"class":"hotjar"},{"search":{"terms":["hour","minute","sand","stopwatch","time"]},"styles":["solid","regular"],"unicode":"f254","label":"Hourglass","free":["solid","regular"],"class":"hourglass"},{"search":{"terms":["hour","minute","sand","stopwatch","time"]},"styles":["solid"],"unicode":"f253","label":"Hourglass End","free":["solid"],"class":"hourglass-end"},{"search":{"terms":["hour","minute","sand","stopwatch","time"]},"styles":["solid"],"unicode":"f252","label":"Hourglass Half","free":["solid"],"class":"hourglass-half"},{"search":{"terms":["hour","minute","sand","stopwatch","time"]},"styles":["solid"],"unicode":"f251","label":"Hourglass Start","free":["solid"],"class":"hourglass-start"},{"search":{"terms":["building","devastation","disaster","home","insurance"]},"styles":["solid"],"unicode":"f6f1","label":"Damaged House","free":["solid"],"class":"house-damage"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f27c","label":"Houzz","free":["brands"],"class":"houzz"},{"search":{"terms":["currency","money","ukraine","ukrainian"]},"styles":["solid"],"unicode":"f6f2","label":"Hryvnia","free":["solid"],"class":"hryvnia"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f13b","label":"HTML 5 Logo","free":["brands"],"class":"html5"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b2","label":"HubSpot","free":["brands"],"class":"hubspot"},{"search":{"terms":["editing","i-beam","type","writing"]},"styles":["solid"],"unicode":"f246","label":"I Beam Cursor","free":["solid"],"class":"i-cursor"},{"search":{"terms":["chocolate","cone","dessert","frozen","scoop","sorbet","vanilla","yogurt"]},"styles":["solid"],"unicode":"f810","label":"Ice Cream","free":["solid"],"class":"ice-cream"},{"search":{"terms":["cold","frozen","hanging","ice","seasonal","sharp"]},"styles":["solid"],"unicode":"f7ad","label":"Icicles","free":["solid"],"class":"icicles"},{"search":{"terms":["bolt","emoji","heart","image","music","photo","symbols"]},"styles":["solid"],"unicode":"f86d","label":"Icons","free":["solid"],"class":"icons"},{"search":{"terms":["address","contact","identification","license","profile"]},"styles":["solid","regular"],"unicode":"f2c1","label":"Identification Badge","free":["solid","regular"],"class":"id-badge"},{"search":{"terms":["contact","demographics","document","identification","issued","profile"]},"styles":["solid","regular"],"unicode":"f2c2","label":"Identification Card","free":["solid","regular"],"class":"id-card"},{"search":{"terms":["contact","demographics","document","identification","issued","profile"]},"styles":["solid"],"unicode":"f47f","label":"Alternate Identification Card","free":["solid"],"class":"id-card-alt"},{"search":{"terms":["dome","dwelling","eskimo","home","house","ice","snow"]},"styles":["solid"],"unicode":"f7ae","label":"Igloo","free":["solid"],"class":"igloo"},{"search":{"terms":["album","landscape","photo","picture"]},"styles":["solid","regular"],"unicode":"f03e","label":"Image","free":["solid","regular"],"class":"image"},{"search":{"terms":["album","landscape","photo","picture"]},"styles":["solid","regular"],"unicode":"f302","label":"Images","free":["solid","regular"],"class":"images"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2d8","label":"IMDB","free":["brands"],"class":"imdb"},{"search":{"terms":["archive","desk","email","mail","message"]},"styles":["solid"],"unicode":"f01c","label":"inbox","free":["solid"],"class":"inbox"},{"search":{"terms":["align","justify","paragraph","tab"]},"styles":["solid"],"unicode":"f03c","label":"Indent","free":["solid"],"class":"indent"},{"search":{"terms":["building","factory","industrial","manufacturing","mill","warehouse"]},"styles":["solid"],"unicode":"f275","label":"Industry","free":["solid"],"class":"industry"},{"search":{"terms":["eternity","forever","math"]},"styles":["solid"],"unicode":"f534","label":"Infinity","free":["solid"],"class":"infinity"},{"search":{"terms":["details","help","information","more","support"]},"styles":["solid"],"unicode":"f129","label":"Info","free":["solid"],"class":"info"},{"search":{"terms":["details","help","information","more","support"]},"styles":["solid"],"unicode":"f05a","label":"Info Circle","free":["solid"],"class":"info-circle"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f16d","label":"Instagram","free":["brands"],"class":"instagram"},{"search":{"terms":["app","customer","messenger"]},"styles":["brands"],"unicode":"f7af","label":"Intercom","free":["brands"],"class":"intercom"},{"search":{"terms":["browser","ie"]},"styles":["brands"],"unicode":"f26b","label":"Internet-explorer","free":["brands"],"class":"internet-explorer"},{"search":{"terms":["app","design","interface"]},"styles":["brands"],"unicode":"f7b0","label":"InVision","free":["brands"],"class":"invision"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f208","label":"ioxhost","free":["brands"],"class":"ioxhost"},{"search":{"terms":["edit","emphasis","font","format","text","type"]},"styles":["solid"],"unicode":"f033","label":"italic","free":["solid"],"class":"italic"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f83a","label":"itch.io","free":["brands"],"class":"itch-io"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b4","label":"iTunes","free":["brands"],"class":"itunes"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b5","label":"Itunes Note","free":["brands"],"class":"itunes-note"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4e4","label":"Java","free":["brands"],"class":"java"},{"search":{"terms":["crest","force","sith","skywalker","star wars","yoda"]},"styles":["solid"],"unicode":"f669","label":"Jedi","free":["solid"],"class":"jedi"},{"search":{"terms":["star wars"]},"styles":["brands"],"unicode":"f50e","label":"Jedi Order","free":["brands"],"class":"jedi-order"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b6","label":"Jenkis","free":["brands"],"class":"jenkins"},{"search":{"terms":["atlassian"]},"styles":["brands"],"unicode":"f7b1","label":"Jira","free":["brands"],"class":"jira"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b7","label":"Joget","free":["brands"],"class":"joget"},{"search":{"terms":["blunt","cannabis","doobie","drugs","marijuana","roach","smoke","smoking","spliff"]},"styles":["solid"],"unicode":"f595","label":"Joint","free":["solid"],"class":"joint"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1aa","label":"Joomla Logo","free":["brands"],"class":"joomla"},{"search":{"terms":["book","force","jedi","sith","star wars","yoda"]},"styles":["solid"],"unicode":"f66a","label":"Journal of the Whills","free":["solid"],"class":"journal-whills"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b8","label":"JavaScript (JS)","free":["brands"],"class":"js"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3b9","label":"JavaScript (JS) Square","free":["brands"],"class":"js-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1cc","label":"jsFiddle","free":["brands"],"class":"jsfiddle"},{"search":{"terms":["building","cube","islam","muslim"]},"styles":["solid"],"unicode":"f66b","label":"Kaaba","free":["solid"],"class":"kaaba"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5fa","label":"Kaggle","free":["brands"],"class":"kaggle"},{"search":{"terms":["lock","password","private","secret","unlock"]},"styles":["solid"],"unicode":"f084","label":"key","free":["solid"],"class":"key"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f5","label":"Keybase","free":["brands"],"class":"keybase"},{"search":{"terms":["accessory","edit","input","text","type","write"]},"styles":["solid","regular"],"unicode":"f11c","label":"Keyboard","free":["solid","regular"],"class":"keyboard"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ba","label":"KeyCDN","free":["brands"],"class":"keycdn"},{"search":{"terms":["chakkar","sikh","sikhism","sword"]},"styles":["solid"],"unicode":"f66d","label":"Khanda","free":["solid"],"class":"khanda"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3bb","label":"Kickstarter","free":["brands"],"class":"kickstarter"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3bc","label":"Kickstarter K","free":["brands"],"class":"kickstarter-k"},{"search":{"terms":["beso","emoticon","face","love","smooch"]},"styles":["solid","regular"],"unicode":"f596","label":"Kissing Face","free":["solid","regular"],"class":"kiss"},{"search":{"terms":["beso","emoticon","face","love","smooch"]},"styles":["solid","regular"],"unicode":"f597","label":"Kissing Face With Smiling Eyes","free":["solid","regular"],"class":"kiss-beam"},{"search":{"terms":["beso","emoticon","face","love","smooch"]},"styles":["solid","regular"],"unicode":"f598","label":"Face Blowing a Kiss","free":["solid","regular"],"class":"kiss-wink-heart"},{"search":{"terms":["bird","fauna","new zealand"]},"styles":["solid"],"unicode":"f535","label":"Kiwi Bird","free":["solid"],"class":"kiwi-bird"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f42f","label":"KORVUE","free":["brands"],"class":"korvue"},{"search":{"terms":["building","historic","memorable","monument","politics"]},"styles":["solid"],"unicode":"f66f","label":"Landmark","free":["solid"],"class":"landmark"},{"search":{"terms":["dialect","idiom","localize","speech","translate","vernacular"]},"styles":["solid"],"unicode":"f1ab","label":"Language","free":["solid"],"class":"language"},{"search":{"terms":["computer","cpu","dell","demo","device","mac","macbook","machine","pc"]},"styles":["solid"],"unicode":"f109","label":"Laptop","free":["solid"],"class":"laptop"},{"search":{"terms":["computer","cpu","dell","demo","develop","device","mac","macbook","machine","pc"]},"styles":["solid"],"unicode":"f5fc","label":"Laptop Code","free":["solid"],"class":"laptop-code"},{"search":{"terms":["computer","device","ehr","electronic health records","history"]},"styles":["solid"],"unicode":"f812","label":"Laptop Medical","free":["solid"],"class":"laptop-medical"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3bd","label":"Laravel","free":["brands"],"class":"laravel"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f202","label":"last.fm","free":["brands"],"class":"lastfm"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f203","label":"last.fm Square","free":["brands"],"class":"lastfm-square"},{"search":{"terms":["LOL","emoticon","face","laugh","smile"]},"styles":["solid","regular"],"unicode":"f599","label":"Grinning Face With Big Eyes","free":["solid","regular"],"class":"laugh"},{"search":{"terms":["LOL","emoticon","face","happy","smile"]},"styles":["solid","regular"],"unicode":"f59a","label":"Laugh Face with Beaming Eyes","free":["solid","regular"],"class":"laugh-beam"},{"search":{"terms":["LOL","emoticon","face","happy","smile"]},"styles":["solid","regular"],"unicode":"f59b","label":"Laughing Squinting Face","free":["solid","regular"],"class":"laugh-squint"},{"search":{"terms":["LOL","emoticon","face","happy","smile"]},"styles":["solid","regular"],"unicode":"f59c","label":"Laughing Winking Face","free":["solid","regular"],"class":"laugh-wink"},{"search":{"terms":["arrange","develop","layers","map","stack"]},"styles":["solid"],"unicode":"f5fd","label":"Layer Group","free":["solid"],"class":"layer-group"},{"search":{"terms":["eco","flora","nature","plant","vegan"]},"styles":["solid"],"unicode":"f06c","label":"leaf","free":["solid"],"class":"leaf"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f212","label":"Leanpub","free":["brands"],"class":"leanpub"},{"search":{"terms":["citrus","lemonade","lime","tart"]},"styles":["solid","regular"],"unicode":"f094","label":"Lemon","free":["solid","regular"],"class":"lemon"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f41d","label":"Less","free":["brands"],"class":"less"},{"search":{"terms":["arithmetic","compare","math"]},"styles":["solid"],"unicode":"f536","label":"Less Than","free":["solid"],"class":"less-than"},{"search":{"terms":["arithmetic","compare","math"]},"styles":["solid"],"unicode":"f537","label":"Less Than Equal To","free":["solid"],"class":"less-than-equal"},{"search":{"terms":["arrow","level-down"]},"styles":["solid"],"unicode":"f3be","label":"Alternate Level Down","free":["solid"],"class":"level-down-alt"},{"search":{"terms":["arrow","level-up"]},"styles":["solid"],"unicode":"f3bf","label":"Alternate Level Up","free":["solid"],"class":"level-up-alt"},{"search":{"terms":["coast guard","help","overboard","save","support"]},"styles":["solid","regular"],"unicode":"f1cd","label":"Life Ring","free":["solid","regular"],"class":"life-ring"},{"search":{"terms":["energy","idea","inspiration","light"]},"styles":["solid","regular"],"unicode":"f0eb","label":"Lightbulb","free":["solid","regular"],"class":"lightbulb"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3c0","label":"Line","free":["brands"],"class":"line"},{"search":{"terms":["attach","attachment","chain","connect"]},"styles":["solid"],"unicode":"f0c1","label":"Link","free":["solid"],"class":"link"},{"search":{"terms":["linkedin-square"]},"styles":["brands"],"unicode":"f08c","label":"LinkedIn","free":["brands"],"class":"linkedin"},{"search":{"terms":["linkedin"]},"styles":["brands"],"unicode":"f0e1","label":"LinkedIn In","free":["brands"],"class":"linkedin-in"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2b8","label":"Linode","free":["brands"],"class":"linode"},{"search":{"terms":["tux"]},"styles":["brands"],"unicode":"f17c","label":"Linux","free":["brands"],"class":"linux"},{"search":{"terms":["currency","money","try","turkish"]},"styles":["solid"],"unicode":"f195","label":"Turkish Lira Sign","free":["solid"],"class":"lira-sign"},{"search":{"terms":["checklist","completed","done","finished","ol","todo","ul"]},"styles":["solid"],"unicode":"f03a","label":"List","free":["solid"],"class":"list"},{"search":{"terms":["checklist","completed","done","finished","ol","todo","ul"]},"styles":["solid","regular"],"unicode":"f022","label":"Alternate List","free":["solid","regular"],"class":"list-alt"},{"search":{"terms":["checklist","completed","done","finished","numbers","ol","todo","ul"]},"styles":["solid"],"unicode":"f0cb","label":"list-ol","free":["solid"],"class":"list-ol"},{"search":{"terms":["checklist","completed","done","finished","ol","todo","ul"]},"styles":["solid"],"unicode":"f0ca","label":"list-ul","free":["solid"],"class":"list-ul"},{"search":{"terms":["address","compass","coordinate","direction","gps","map","navigation","place"]},"styles":["solid"],"unicode":"f124","label":"location-arrow","free":["solid"],"class":"location-arrow"},{"search":{"terms":["admin","lock","open","password","private","protect","security"]},"styles":["solid"],"unicode":"f023","label":"lock","free":["solid"],"class":"lock"},{"search":{"terms":["admin","lock","open","password","private","protect","security"]},"styles":["solid"],"unicode":"f3c1","label":"Lock Open","free":["solid"],"class":"lock-open"},{"search":{"terms":["download","long-arrow-down"]},"styles":["solid"],"unicode":"f309","label":"Alternate Long Arrow Down","free":["solid"],"class":"long-arrow-alt-down"},{"search":{"terms":["back","long-arrow-left","previous"]},"styles":["solid"],"unicode":"f30a","label":"Alternate Long Arrow Left","free":["solid"],"class":"long-arrow-alt-left"},{"search":{"terms":["forward","long-arrow-right","next"]},"styles":["solid"],"unicode":"f30b","label":"Alternate Long Arrow Right","free":["solid"],"class":"long-arrow-alt-right"},{"search":{"terms":["long-arrow-up","upload"]},"styles":["solid"],"unicode":"f30c","label":"Alternate Long Arrow Up","free":["solid"],"class":"long-arrow-alt-up"},{"search":{"terms":["blind","eye","sight"]},"styles":["solid"],"unicode":"f2a8","label":"Low Vision","free":["solid"],"class":"low-vision"},{"search":{"terms":["bag","baggage","suitcase","travel"]},"styles":["solid"],"unicode":"f59d","label":"Luggage Cart","free":["solid"],"class":"luggage-cart"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3c3","label":"lyft","free":["brands"],"class":"lyft"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3c4","label":"Magento","free":["brands"],"class":"magento"},{"search":{"terms":["autocomplete","automatic","mage","magic","spell","wand","witch","wizard"]},"styles":["solid"],"unicode":"f0d0","label":"magic","free":["solid"],"class":"magic"},{"search":{"terms":["Attract","lodestone","tool"]},"styles":["solid"],"unicode":"f076","label":"magnet","free":["solid"],"class":"magnet"},{"search":{"terms":["archive","envelope","letter","post office","postal","postcard","send","stamp","usps"]},"styles":["solid"],"unicode":"f674","label":"Mail Bulk","free":["solid"],"class":"mail-bulk"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f59e","label":"Mailchimp","free":["brands"],"class":"mailchimp"},{"search":{"terms":["human","man","person","profile","user"]},"styles":["solid"],"unicode":"f183","label":"Male","free":["solid"],"class":"male"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f50f","label":"Mandalorian","free":["brands"],"class":"mandalorian"},{"search":{"terms":["address","coordinates","destination","gps","localize","location","map","navigation","paper","pin","place","point of interest","position","route","travel"]},"styles":["solid","regular"],"unicode":"f279","label":"Map","free":["solid","regular"],"class":"map"},{"search":{"terms":["address","coordinates","destination","gps","localize","location","map","navigation","paper","pin","place","point of interest","position","route","travel"]},"styles":["solid"],"unicode":"f59f","label":"Map Marked","free":["solid"],"class":"map-marked"},{"search":{"terms":["address","coordinates","destination","gps","localize","location","map","navigation","paper","pin","place","point of interest","position","route","travel"]},"styles":["solid"],"unicode":"f5a0","label":"Alternate Map Marked","free":["solid"],"class":"map-marked-alt"},{"search":{"terms":["address","coordinates","destination","gps","localize","location","map","navigation","paper","pin","place","point of interest","position","route","travel"]},"styles":["solid"],"unicode":"f041","label":"map-marker","free":["solid"],"class":"map-marker"},{"search":{"terms":["address","coordinates","destination","gps","localize","location","map","navigation","paper","pin","place","point of interest","position","route","travel"]},"styles":["solid"],"unicode":"f3c5","label":"Alternate Map Marker","free":["solid"],"class":"map-marker-alt"},{"search":{"terms":["address","agree","coordinates","destination","gps","localize","location","map","marker","navigation","pin","place","position","travel"]},"styles":["solid"],"unicode":"f276","label":"Map Pin","free":["solid"],"class":"map-pin"},{"search":{"terms":["directions","directory","map","signage","wayfinding"]},"styles":["solid"],"unicode":"f277","label":"Map Signs","free":["solid"],"class":"map-signs"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f60f","label":"Markdown","free":["brands"],"class":"markdown"},{"search":{"terms":["design","edit","sharpie","update","write"]},"styles":["solid"],"unicode":"f5a1","label":"Marker","free":["solid"],"class":"marker"},{"search":{"terms":["male"]},"styles":["solid"],"unicode":"f222","label":"Mars","free":["solid"],"class":"mars"},{"search":{"terms":[]},"styles":["solid"],"unicode":"f227","label":"Mars Double","free":["solid"],"class":"mars-double"},{"search":{"terms":[]},"styles":["solid"],"unicode":"f229","label":"Mars Stroke","free":["solid"],"class":"mars-stroke"},{"search":{"terms":[]},"styles":["solid"],"unicode":"f22b","label":"Mars Stroke Horizontal","free":["solid"],"class":"mars-stroke-h"},{"search":{"terms":[]},"styles":["solid"],"unicode":"f22a","label":"Mars Stroke Vertical","free":["solid"],"class":"mars-stroke-v"},{"search":{"terms":["carnivale","costume","disguise","halloween","secret","super hero"]},"styles":["solid"],"unicode":"f6fa","label":"Mask","free":["solid"],"class":"mask"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f6","label":"Mastodon","free":["brands"],"class":"mastodon"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f136","label":"MaxCDN","free":["brands"],"class":"maxcdn"},{"search":{"terms":["award","ribbon","star","trophy"]},"styles":["solid"],"unicode":"f5a2","label":"Medal","free":["solid"],"class":"medal"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3c6","label":"MedApps","free":["brands"],"class":"medapps"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f23a","label":"Medium","free":["brands"],"class":"medium"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3c7","label":"Medium M","free":["brands"],"class":"medium-m"},{"search":{"terms":["first aid","firstaid","health","help","support"]},"styles":["solid"],"unicode":"f0fa","label":"medkit","free":["solid"],"class":"medkit"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3c8","label":"MRT","free":["brands"],"class":"medrt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2e0","label":"Meetup","free":["brands"],"class":"meetup"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5a3","label":"Megaport","free":["brands"],"class":"megaport"},{"search":{"terms":["emoticon","face","neutral","rating"]},"styles":["solid","regular"],"unicode":"f11a","label":"Neutral Face","free":["solid","regular"],"class":"meh"},{"search":{"terms":["emoticon","face","neutral","rating"]},"styles":["solid","regular"],"unicode":"f5a4","label":"Face Without Mouth","free":["solid","regular"],"class":"meh-blank"},{"search":{"terms":["emoticon","face","neutral","rating"]},"styles":["solid","regular"],"unicode":"f5a5","label":"Face With Rolling Eyes","free":["solid","regular"],"class":"meh-rolling-eyes"},{"search":{"terms":["DIMM","RAM","hardware","storage","technology"]},"styles":["solid"],"unicode":"f538","label":"Memory","free":["solid"],"class":"memory"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f7b3","label":"Mendeley","free":["brands"],"class":"mendeley"},{"search":{"terms":["candle","hanukkah","jewish","judaism","light"]},"styles":["solid"],"unicode":"f676","label":"Menorah","free":["solid"],"class":"menorah"},{"search":{"terms":["transgender"]},"styles":["solid"],"unicode":"f223","label":"Mercury","free":["solid"],"class":"mercury"},{"search":{"terms":["armageddon","asteroid","comet","shooting star","space"]},"styles":["solid"],"unicode":"f753","label":"Meteor","free":["solid"],"class":"meteor"},{"search":{"terms":["cpu","hardware","processor","technology"]},"styles":["solid"],"unicode":"f2db","label":"Microchip","free":["solid"],"class":"microchip"},{"search":{"terms":["audio","podcast","record","sing","sound","voice"]},"styles":["solid"],"unicode":"f130","label":"microphone","free":["solid"],"class":"microphone"},{"search":{"terms":["audio","podcast","record","sing","sound","voice"]},"styles":["solid"],"unicode":"f3c9","label":"Alternate Microphone","free":["solid"],"class":"microphone-alt"},{"search":{"terms":["audio","disable","mute","podcast","record","sing","sound","voice"]},"styles":["solid"],"unicode":"f539","label":"Alternate Microphone Slash","free":["solid"],"class":"microphone-alt-slash"},{"search":{"terms":["audio","disable","mute","podcast","record","sing","sound","voice"]},"styles":["solid"],"unicode":"f131","label":"Microphone Slash","free":["solid"],"class":"microphone-slash"},{"search":{"terms":["electron","lens","optics","science","shrink"]},"styles":["solid"],"unicode":"f610","label":"Microscope","free":["solid"],"class":"microscope"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ca","label":"Microsoft","free":["brands"],"class":"microsoft"},{"search":{"terms":["collapse","delete","hide","minify","negative","remove","trash"]},"styles":["solid"],"unicode":"f068","label":"minus","free":["solid"],"class":"minus"},{"search":{"terms":["delete","hide","negative","remove","shape","trash"]},"styles":["solid"],"unicode":"f056","label":"Minus Circle","free":["solid"],"class":"minus-circle"},{"search":{"terms":["collapse","delete","hide","minify","negative","remove","shape","trash"]},"styles":["solid","regular"],"unicode":"f146","label":"Minus Square","free":["solid","regular"],"class":"minus-square"},{"search":{"terms":["clothing","cold","glove","hands","knitted","seasonal","warmth"]},"styles":["solid"],"unicode":"f7b5","label":"Mitten","free":["solid"],"class":"mitten"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3cb","label":"Mix","free":["brands"],"class":"mix"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f289","label":"Mixcloud","free":["brands"],"class":"mixcloud"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3cc","label":"Mizuni","free":["brands"],"class":"mizuni"},{"search":{"terms":["apple","call","cell phone","cellphone","device","iphone","number","screen","telephone"]},"styles":["solid"],"unicode":"f10b","label":"Mobile Phone","free":["solid"],"class":"mobile"},{"search":{"terms":["apple","call","cell phone","cellphone","device","iphone","number","screen","telephone"]},"styles":["solid"],"unicode":"f3cd","label":"Alternate Mobile","free":["solid"],"class":"mobile-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f285","label":"MODX","free":["brands"],"class":"modx"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d0","label":"Monero","free":["brands"],"class":"monero"},{"search":{"terms":["buy","cash","checkout","money","payment","price","purchase"]},"styles":["solid"],"unicode":"f0d6","label":"Money Bill","free":["solid"],"class":"money-bill"},{"search":{"terms":["buy","cash","checkout","money","payment","price","purchase"]},"styles":["solid","regular"],"unicode":"f3d1","label":"Alternate Money Bill","free":["solid","regular"],"class":"money-bill-alt"},{"search":{"terms":["buy","cash","checkout","money","payment","price","purchase"]},"styles":["solid"],"unicode":"f53a","label":"Wavy Money Bill","free":["solid"],"class":"money-bill-wave"},{"search":{"terms":["buy","cash","checkout","money","payment","price","purchase"]},"styles":["solid"],"unicode":"f53b","label":"Alternate Wavy Money Bill","free":["solid"],"class":"money-bill-wave-alt"},{"search":{"terms":["bank check","buy","checkout","cheque","money","payment","price","purchase"]},"styles":["solid"],"unicode":"f53c","label":"Money Check","free":["solid"],"class":"money-check"},{"search":{"terms":["bank check","buy","checkout","cheque","money","payment","price","purchase"]},"styles":["solid"],"unicode":"f53d","label":"Alternate Money Check","free":["solid"],"class":"money-check-alt"},{"search":{"terms":["building","historic","landmark","memorable"]},"styles":["solid"],"unicode":"f5a6","label":"Monument","free":["solid"],"class":"monument"},{"search":{"terms":["contrast","crescent","dark","lunar","night"]},"styles":["solid","regular"],"unicode":"f186","label":"Moon","free":["solid","regular"],"class":"moon"},{"search":{"terms":["crush","culinary","grind","medical","mix","pharmacy","prescription","spices"]},"styles":["solid"],"unicode":"f5a7","label":"Mortar Pestle","free":["solid"],"class":"mortar-pestle"},{"search":{"terms":["building","islam","landmark","muslim"]},"styles":["solid"],"unicode":"f678","label":"Mosque","free":["solid"],"class":"mosque"},{"search":{"terms":["bike","machine","transportation","vehicle"]},"styles":["solid"],"unicode":"f21c","label":"Motorcycle","free":["solid"],"class":"motorcycle"},{"search":{"terms":["glacier","hiking","hill","landscape","travel","view"]},"styles":["solid"],"unicode":"f6fc","label":"Mountain","free":["solid"],"class":"mountain"},{"search":{"terms":["arrow","cursor","select"]},"styles":["solid"],"unicode":"f245","label":"Mouse Pointer","free":["solid"],"class":"mouse-pointer"},{"search":{"terms":["caliente","cocoa","coffee","cup","drink","holiday","hot chocolate","steam","tea","warmth"]},"styles":["solid"],"unicode":"f7b6","label":"Mug Hot","free":["solid"],"class":"mug-hot"},{"search":{"terms":["lyrics","melody","note","sing","sound"]},"styles":["solid"],"unicode":"f001","label":"Music","free":["solid"],"class":"music"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d2","label":"Napster","free":["brands"],"class":"napster"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f612","label":"Neos","free":["brands"],"class":"neos"},{"search":{"terms":["computer","connect","ethernet","internet","intranet"]},"styles":["solid"],"unicode":"f6ff","label":"Wired Network","free":["solid"],"class":"network-wired"},{"search":{"terms":[]},"styles":["solid"],"unicode":"f22c","label":"Neuter","free":["solid"],"class":"neuter"},{"search":{"terms":["article","editorial","headline","journal","journalism","news","press"]},"styles":["solid","regular"],"unicode":"f1ea","label":"Newspaper","free":["solid","regular"],"class":"newspaper"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5a8","label":"Nimblr","free":["brands"],"class":"nimblr"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f419","label":"Node.js","free":["brands"],"class":"node"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d3","label":"Node.js JS","free":["brands"],"class":"node-js"},{"search":{"terms":["arithmetic","compare","math"]},"styles":["solid"],"unicode":"f53e","label":"Not Equal","free":["solid"],"class":"not-equal"},{"search":{"terms":["clipboard","doctor","ehr","health","history","records"]},"styles":["solid"],"unicode":"f481","label":"Medical Notes","free":["solid"],"class":"notes-medical"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d4","label":"npm","free":["brands"],"class":"npm"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d5","label":"NS8","free":["brands"],"class":"ns8"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d6","label":"Nutritionix","free":["brands"],"class":"nutritionix"},{"search":{"terms":["combine","copy","design","merge","select"]},"styles":["solid","regular"],"unicode":"f247","label":"Object Group","free":["solid","regular"],"class":"object-group"},{"search":{"terms":["copy","design","merge","select","separate"]},"styles":["solid","regular"],"unicode":"f248","label":"Object Ungroup","free":["solid","regular"],"class":"object-ungroup"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f263","label":"Odnoklassniki","free":["brands"],"class":"odnoklassniki"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f264","label":"Odnoklassniki Square","free":["brands"],"class":"odnoklassniki-square"},{"search":{"terms":["auto","crude","gasoline","grease","lubricate","petroleum"]},"styles":["solid"],"unicode":"f613","label":"Oil Can","free":["solid"],"class":"oil-can"},{"search":{"terms":["politics","star wars"]},"styles":["brands"],"unicode":"f510","label":"Old Republic","free":["brands"],"class":"old-republic"},{"search":{"terms":["buddhism","hinduism","jainism","mantra"]},"styles":["solid"],"unicode":"f679","label":"Om","free":["solid"],"class":"om"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f23d","label":"OpenCart","free":["brands"],"class":"opencart"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f19b","label":"OpenID","free":["brands"],"class":"openid"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f26a","label":"Opera","free":["brands"],"class":"opera"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f23c","label":"Optin Monster","free":["brands"],"class":"optin-monster"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f41a","label":"Open Source Initiative","free":["brands"],"class":"osi"},{"search":{"terms":["animal","badger","fauna","fur","mammal","marten"]},"styles":["solid"],"unicode":"f700","label":"Otter","free":["solid"],"class":"otter"},{"search":{"terms":["align","justify","paragraph","tab"]},"styles":["solid"],"unicode":"f03b","label":"Outdent","free":["solid"],"class":"outdent"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d7","label":"page4 Corporation","free":["brands"],"class":"page4"},{"search":{"terms":["eco","flora","leaf","leaves","nature","plant","tree"]},"styles":["brands"],"unicode":"f18c","label":"Pagelines","free":["brands"],"class":"pagelines"},{"search":{"terms":["beeper","cellphone","communication"]},"styles":["solid"],"unicode":"f815","label":"Pager","free":["solid"],"class":"pager"},{"search":{"terms":["acrylic","art","brush","color","fill","paint","pigment","watercolor"]},"styles":["solid"],"unicode":"f1fc","label":"Paint Brush","free":["solid"],"class":"paint-brush"},{"search":{"terms":["acrylic","art","brush","color","fill","paint","pigment","watercolor"]},"styles":["solid"],"unicode":"f5aa","label":"Paint Roller","free":["solid"],"class":"paint-roller"},{"search":{"terms":["acrylic","art","brush","color","fill","paint","pigment","watercolor"]},"styles":["solid"],"unicode":"f53f","label":"Palette","free":["solid"],"class":"palette"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d8","label":"Palfed","free":["brands"],"class":"palfed"},{"search":{"terms":["archive","box","inventory","shipping","warehouse"]},"styles":["solid"],"unicode":"f482","label":"Pallet","free":["solid"],"class":"pallet"},{"search":{"terms":["air","float","fold","mail","paper","send"]},"styles":["solid","regular"],"unicode":"f1d8","label":"Paper Plane","free":["solid","regular"],"class":"paper-plane"},{"search":{"terms":["attach","attachment","connect","link"]},"styles":["solid"],"unicode":"f0c6","label":"Paperclip","free":["solid"],"class":"paperclip"},{"search":{"terms":["aid","assistance","rescue","supplies"]},"styles":["solid"],"unicode":"f4cd","label":"Parachute Box","free":["solid"],"class":"parachute-box"},{"search":{"terms":["edit","format","text","writing"]},"styles":["solid"],"unicode":"f1dd","label":"paragraph","free":["solid"],"class":"paragraph"},{"search":{"terms":["auto","car","garage","meter"]},"styles":["solid"],"unicode":"f540","label":"Parking","free":["solid"],"class":"parking"},{"search":{"terms":["document","id","identification","issued","travel"]},"styles":["solid"],"unicode":"f5ab","label":"Passport","free":["solid"],"class":"passport"},{"search":{"terms":["agnosticism","atheism","flying spaghetti monster","fsm"]},"styles":["solid"],"unicode":"f67b","label":"Pastafarianism","free":["solid"],"class":"pastafarianism"},{"search":{"terms":["clipboard","copy","document","paper"]},"styles":["solid"],"unicode":"f0ea","label":"Paste","free":["solid"],"class":"paste"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3d9","label":"Patreon","free":["brands"],"class":"patreon"},{"search":{"terms":["hold","wait"]},"styles":["solid"],"unicode":"f04c","label":"pause","free":["solid"],"class":"pause"},{"search":{"terms":["hold","wait"]},"styles":["solid","regular"],"unicode":"f28b","label":"Pause Circle","free":["solid","regular"],"class":"pause-circle"},{"search":{"terms":["animal","cat","dog","pet","print"]},"styles":["solid"],"unicode":"f1b0","label":"Paw","free":["solid"],"class":"paw"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1ed","label":"Paypal","free":["brands"],"class":"paypal"},{"search":{"terms":["serenity","tranquility","truce","war"]},"styles":["solid"],"unicode":"f67c","label":"Peace","free":["solid"],"class":"peace"},{"search":{"terms":["design","edit","update","write"]},"styles":["solid"],"unicode":"f304","label":"Pen","free":["solid"],"class":"pen"},{"search":{"terms":["design","edit","update","write"]},"styles":["solid"],"unicode":"f305","label":"Alternate Pen","free":["solid"],"class":"pen-alt"},{"search":{"terms":["design","edit","fountain pen","update","write"]},"styles":["solid"],"unicode":"f5ac","label":"Pen Fancy","free":["solid"],"class":"pen-fancy"},{"search":{"terms":["design","edit","fountain pen","update","write"]},"styles":["solid"],"unicode":"f5ad","label":"Pen Nib","free":["solid"],"class":"pen-nib"},{"search":{"terms":["edit","pencil-square","update","write"]},"styles":["solid"],"unicode":"f14b","label":"Pen Square","free":["solid"],"class":"pen-square"},{"search":{"terms":["design","edit","pencil","update","write"]},"styles":["solid"],"unicode":"f303","label":"Alternate Pencil","free":["solid"],"class":"pencil-alt"},{"search":{"terms":["design","draft","draw","pencil"]},"styles":["solid"],"unicode":"f5ae","label":"Pencil Ruler","free":["solid"],"class":"pencil-ruler"},{"search":{"terms":["Dungeons & Dragons","d&d","dnd","fantasy","game","gaming","pax","tabletop"]},"styles":["brands"],"unicode":"f704","label":"Penny Arcade","free":["brands"],"class":"penny-arcade"},{"search":{"terms":["box","carry","fragile","help","movers","package"]},"styles":["solid"],"unicode":"f4ce","label":"People Carry","free":["solid"],"class":"people-carry"},{"search":{"terms":["buffalo wings","capsicum","chili","chilli","habanero","jalapeno","mexican","spicy","tabasco","vegetable"]},"styles":["solid"],"unicode":"f816","label":"Hot Pepper","free":["solid"],"class":"pepper-hot"},{"search":{"terms":["discount","fraction","proportion","rate","ratio"]},"styles":["solid"],"unicode":"f295","label":"Percent","free":["solid"],"class":"percent"},{"search":{"terms":["discount","fraction","proportion","rate","ratio"]},"styles":["solid"],"unicode":"f541","label":"Percentage","free":["solid"],"class":"percentage"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3da","label":"Periscope","free":["brands"],"class":"periscope"},{"search":{"terms":["changing","changing room","election","human","person","vote","voting"]},"styles":["solid"],"unicode":"f756","label":"Person Entering Booth","free":["solid"],"class":"person-booth"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3db","label":"Phabricator","free":["brands"],"class":"phabricator"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3dc","label":"Phoenix Framework","free":["brands"],"class":"phoenix-framework"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f511","label":"Phoenix Squadron","free":["brands"],"class":"phoenix-squadron"},{"search":{"terms":["call","earphone","number","support","telephone","voice"]},"styles":["solid"],"unicode":"f095","label":"Phone","free":["solid"],"class":"phone"},{"search":{"terms":["call","earphone","number","support","telephone","voice"]},"styles":["solid"],"unicode":"f879","label":"Alternate Phone","free":["solid"],"class":"phone-alt"},{"search":{"terms":["call","cancel","earphone","mute","number","support","telephone","voice"]},"styles":["solid"],"unicode":"f3dd","label":"Phone Slash","free":["solid"],"class":"phone-slash"},{"search":{"terms":["call","earphone","number","support","telephone","voice"]},"styles":["solid"],"unicode":"f098","label":"Phone Square","free":["solid"],"class":"phone-square"},{"search":{"terms":["call","earphone","number","support","telephone","voice"]},"styles":["solid"],"unicode":"f87b","label":"Alternate Phone Square","free":["solid"],"class":"phone-square-alt"},{"search":{"terms":["call","earphone","number","sound","support","telephone","voice","volume-control-phone"]},"styles":["solid"],"unicode":"f2a0","label":"Phone Volume","free":["solid"],"class":"phone-volume"},{"search":{"terms":["av","film","image","library","media"]},"styles":["solid"],"unicode":"f87c","label":"Photo Video","free":["solid"],"class":"photo-video"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f457","label":"PHP","free":["brands"],"class":"php"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2ae","label":"Pied Piper Logo","free":["brands"],"class":"pied-piper"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a8","label":"Alternate Pied Piper Logo","free":["brands"],"class":"pied-piper-alt"},{"search":{"terms":["clothing"]},"styles":["brands"],"unicode":"f4e5","label":"Pied Piper-hat","free":["brands"],"class":"pied-piper-hat"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a7","label":"Pied Piper PP Logo (Old)","free":["brands"],"class":"pied-piper-pp"},{"search":{"terms":["bank","save","savings"]},"styles":["solid"],"unicode":"f4d3","label":"Piggy Bank","free":["solid"],"class":"piggy-bank"},{"search":{"terms":["drugs","medicine","prescription","tablets"]},"styles":["solid"],"unicode":"f484","label":"Pills","free":["solid"],"class":"pills"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f0d2","label":"Pinterest","free":["brands"],"class":"pinterest"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f231","label":"Pinterest P","free":["brands"],"class":"pinterest-p"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f0d3","label":"Pinterest Square","free":["brands"],"class":"pinterest-square"},{"search":{"terms":["cheese","chicago","italian","mozzarella","new york","pepperoni","pie","slice","teenage mutant ninja turtles","tomato"]},"styles":["solid"],"unicode":"f818","label":"Pizza Slice","free":["solid"],"class":"pizza-slice"},{"search":{"terms":["building","church","holy","mosque","synagogue"]},"styles":["solid"],"unicode":"f67f","label":"Place of Worship","free":["solid"],"class":"place-of-worship"},{"search":{"terms":["airplane","destination","fly","location","mode","travel","trip"]},"styles":["solid"],"unicode":"f072","label":"plane","free":["solid"],"class":"plane"},{"search":{"terms":["airplane","arriving","destination","fly","land","landing","location","mode","travel","trip"]},"styles":["solid"],"unicode":"f5af","label":"Plane Arrival","free":["solid"],"class":"plane-arrival"},{"search":{"terms":["airplane","departing","destination","fly","location","mode","take off","taking off","travel","trip"]},"styles":["solid"],"unicode":"f5b0","label":"Plane Departure","free":["solid"],"class":"plane-departure"},{"search":{"terms":["audio","music","playing","sound","start","video"]},"styles":["solid"],"unicode":"f04b","label":"play","free":["solid"],"class":"play"},{"search":{"terms":["audio","music","playing","sound","start","video"]},"styles":["solid","regular"],"unicode":"f144","label":"Play Circle","free":["solid","regular"],"class":"play-circle"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3df","label":"PlayStation","free":["brands"],"class":"playstation"},{"search":{"terms":["connect","electric","online","power"]},"styles":["solid"],"unicode":"f1e6","label":"Plug","free":["solid"],"class":"plug"},{"search":{"terms":["add","create","expand","new","positive","shape"]},"styles":["solid"],"unicode":"f067","label":"plus","free":["solid"],"class":"plus"},{"search":{"terms":["add","create","expand","new","positive","shape"]},"styles":["solid"],"unicode":"f055","label":"Plus Circle","free":["solid"],"class":"plus-circle"},{"search":{"terms":["add","create","expand","new","positive","shape"]},"styles":["solid","regular"],"unicode":"f0fe","label":"Plus Square","free":["solid","regular"],"class":"plus-square"},{"search":{"terms":["audio","broadcast","music","sound"]},"styles":["solid"],"unicode":"f2ce","label":"Podcast","free":["solid"],"class":"podcast"},{"search":{"terms":["results","survey","trend","vote","voting"]},"styles":["solid"],"unicode":"f681","label":"Poll","free":["solid"],"class":"poll"},{"search":{"terms":["results","survey","trend","vote","voting"]},"styles":["solid"],"unicode":"f682","label":"Poll H","free":["solid"],"class":"poll-h"},{"search":{"terms":["crap","poop","shit","smile","turd"]},"styles":["solid"],"unicode":"f2fe","label":"Poo","free":["solid"],"class":"poo"},{"search":{"terms":["bolt","cloud","euphemism","lightning","mess","poop","shit","turd"]},"styles":["solid"],"unicode":"f75a","label":"Poo Storm","free":["solid"],"class":"poo-storm"},{"search":{"terms":["crap","poop","shit","smile","turd"]},"styles":["solid"],"unicode":"f619","label":"Poop","free":["solid"],"class":"poop"},{"search":{"terms":["id","image","photo","picture","selfie"]},"styles":["solid"],"unicode":"f3e0","label":"Portrait","free":["solid"],"class":"portrait"},{"search":{"terms":["currency","gbp","money"]},"styles":["solid"],"unicode":"f154","label":"Pound Sign","free":["solid"],"class":"pound-sign"},{"search":{"terms":["cancel","computer","on","reboot","restart"]},"styles":["solid"],"unicode":"f011","label":"Power Off","free":["solid"],"class":"power-off"},{"search":{"terms":["kneel","preach","religion","worship"]},"styles":["solid"],"unicode":"f683","label":"Pray","free":["solid"],"class":"pray"},{"search":{"terms":["kneel","preach","religion","worship"]},"styles":["solid"],"unicode":"f684","label":"Praying Hands","free":["solid"],"class":"praying-hands"},{"search":{"terms":["drugs","medical","medicine","pharmacy","rx"]},"styles":["solid"],"unicode":"f5b1","label":"Prescription","free":["solid"],"class":"prescription"},{"search":{"terms":["drugs","medical","medicine","pharmacy","rx"]},"styles":["solid"],"unicode":"f485","label":"Prescription Bottle","free":["solid"],"class":"prescription-bottle"},{"search":{"terms":["drugs","medical","medicine","pharmacy","rx"]},"styles":["solid"],"unicode":"f486","label":"Alternate Prescription Bottle","free":["solid"],"class":"prescription-bottle-alt"},{"search":{"terms":["business","copy","document","office","paper"]},"styles":["solid"],"unicode":"f02f","label":"print","free":["solid"],"class":"print"},{"search":{"terms":["EKG","bed","electrocardiogram","health","hospital","life","patient","vital"]},"styles":["solid"],"unicode":"f487","label":"Procedures","free":["solid"],"class":"procedures"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f288","label":"Product Hunt","free":["brands"],"class":"product-hunt"},{"search":{"terms":["chart","graph","network","pert"]},"styles":["solid"],"unicode":"f542","label":"Project Diagram","free":["solid"],"class":"project-diagram"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3e1","label":"Pushed","free":["brands"],"class":"pushed"},{"search":{"terms":["add-on","addon","game","section"]},"styles":["solid"],"unicode":"f12e","label":"Puzzle Piece","free":["solid"],"class":"puzzle-piece"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3e2","label":"Python","free":["brands"],"class":"python"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1d6","label":"QQ","free":["brands"],"class":"qq"},{"search":{"terms":["barcode","info","information","scan"]},"styles":["solid"],"unicode":"f029","label":"qrcode","free":["solid"],"class":"qrcode"},{"search":{"terms":["help","information","support","unknown"]},"styles":["solid"],"unicode":"f128","label":"Question","free":["solid"],"class":"question"},{"search":{"terms":["help","information","support","unknown"]},"styles":["solid","regular"],"unicode":"f059","label":"Question Circle","free":["solid","regular"],"class":"question-circle"},{"search":{"terms":["ball","bludger","broom","golden snitch","harry potter","hogwarts","quaffle","sport","wizard"]},"styles":["solid"],"unicode":"f458","label":"Quidditch","free":["solid"],"class":"quidditch"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f459","label":"QuinScape","free":["brands"],"class":"quinscape"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2c4","label":"Quora","free":["brands"],"class":"quora"},{"search":{"terms":["mention","note","phrase","text","type"]},"styles":["solid"],"unicode":"f10d","label":"quote-left","free":["solid"],"class":"quote-left"},{"search":{"terms":["mention","note","phrase","text","type"]},"styles":["solid"],"unicode":"f10e","label":"quote-right","free":["solid"],"class":"quote-right"},{"search":{"terms":["book","islam","muslim","religion"]},"styles":["solid"],"unicode":"f687","label":"Quran","free":["solid"],"class":"quran"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f7","label":"R Project","free":["brands"],"class":"r-project"},{"search":{"terms":["danger","dangerous","deadly","hazard","nuclear","radioactive","warning"]},"styles":["solid"],"unicode":"f7b9","label":"Radiation","free":["solid"],"class":"radiation"},{"search":{"terms":["danger","dangerous","deadly","hazard","nuclear","radioactive","warning"]},"styles":["solid"],"unicode":"f7ba","label":"Alternate Radiation","free":["solid"],"class":"radiation-alt"},{"search":{"terms":["gold","leprechaun","prism","rain","sky"]},"styles":["solid"],"unicode":"f75b","label":"Rainbow","free":["solid"],"class":"rainbow"},{"search":{"terms":["arrows","shuffle","sort","swap","switch","transfer"]},"styles":["solid"],"unicode":"f074","label":"random","free":["solid"],"class":"random"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f7bb","label":"Raspberry Pi","free":["brands"],"class":"raspberry-pi"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2d9","label":"Ravelry","free":["brands"],"class":"ravelry"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f41b","label":"React","free":["brands"],"class":"react"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f75d","label":"ReactEurope","free":["brands"],"class":"reacteurope"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4d5","label":"ReadMe","free":["brands"],"class":"readme"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1d0","label":"Rebel Alliance","free":["brands"],"class":"rebel"},{"search":{"terms":["check","invoice","money","pay","table"]},"styles":["solid"],"unicode":"f543","label":"Receipt","free":["solid"],"class":"receipt"},{"search":{"terms":["Waste","compost","garbage","reuse","trash"]},"styles":["solid"],"unicode":"f1b8","label":"Recycle","free":["solid"],"class":"recycle"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3e3","label":"red river","free":["brands"],"class":"red-river"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a1","label":"reddit Logo","free":["brands"],"class":"reddit"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f281","label":"reddit Alien","free":["brands"],"class":"reddit-alien"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a2","label":"reddit Square","free":["brands"],"class":"reddit-square"},{"search":{"terms":["linux","operating system","os"]},"styles":["brands"],"unicode":"f7bc","label":"Redhat","free":["brands"],"class":"redhat"},{"search":{"terms":["forward","refresh","reload","repeat"]},"styles":["solid"],"unicode":"f01e","label":"Redo","free":["solid"],"class":"redo"},{"search":{"terms":["forward","refresh","reload","repeat"]},"styles":["solid"],"unicode":"f2f9","label":"Alternate Redo","free":["solid"],"class":"redo-alt"},{"search":{"terms":["copyright","mark","trademark"]},"styles":["solid","regular"],"unicode":"f25d","label":"Registered Trademark","free":["solid","regular"],"class":"registered"},{"search":{"terms":["cancel","font","format","remove","style","text"]},"styles":["solid"],"unicode":"f87d","label":"Remove Format","free":["solid"],"class":"remove-format"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f18b","label":"Renren","free":["brands"],"class":"renren"},{"search":{"terms":["mail","message","respond"]},"styles":["solid"],"unicode":"f3e5","label":"Reply","free":["solid"],"class":"reply"},{"search":{"terms":["mail","message","respond"]},"styles":["solid"],"unicode":"f122","label":"reply-all","free":["solid"],"class":"reply-all"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3e6","label":"replyd","free":["brands"],"class":"replyd"},{"search":{"terms":["american","conservative","election","elephant","politics","republican party","right","right-wing","usa"]},"styles":["solid"],"unicode":"f75e","label":"Republican","free":["solid"],"class":"republican"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f8","label":"Researchgate","free":["brands"],"class":"researchgate"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3e7","label":"Resolving","free":["brands"],"class":"resolving"},{"search":{"terms":["bathroom","john","loo","potty","washroom","waste","wc"]},"styles":["solid"],"unicode":"f7bd","label":"Restroom","free":["solid"],"class":"restroom"},{"search":{"terms":["refresh","reload","share","swap"]},"styles":["solid"],"unicode":"f079","label":"Retweet","free":["solid"],"class":"retweet"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5b2","label":"Rev.io","free":["brands"],"class":"rev"},{"search":{"terms":["badge","cause","lapel","pin"]},"styles":["solid"],"unicode":"f4d6","label":"Ribbon","free":["solid"],"class":"ribbon"},{"search":{"terms":["Dungeons & Dragons","Gollum","band","binding","d&d","dnd","engagement","fantasy","gold","jewelry","marriage","precious"]},"styles":["solid"],"unicode":"f70b","label":"Ring","free":["solid"],"class":"ring"},{"search":{"terms":["highway","map","pavement","route","street","travel"]},"styles":["solid"],"unicode":"f018","label":"road","free":["solid"],"class":"road"},{"search":{"terms":["android","automate","computer","cyborg"]},"styles":["solid"],"unicode":"f544","label":"Robot","free":["solid"],"class":"robot"},{"search":{"terms":["aircraft","app","jet","launch","nasa","space"]},"styles":["solid"],"unicode":"f135","label":"rocket","free":["solid"],"class":"rocket"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3e8","label":"Rocket.Chat","free":["brands"],"class":"rocketchat"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3e9","label":"Rockrms","free":["brands"],"class":"rockrms"},{"search":{"terms":["directions","navigation","travel"]},"styles":["solid"],"unicode":"f4d7","label":"Route","free":["solid"],"class":"route"},{"search":{"terms":["blog","feed","journal","news","writing"]},"styles":["solid"],"unicode":"f09e","label":"rss","free":["solid"],"class":"rss"},{"search":{"terms":["blog","feed","journal","news","writing"]},"styles":["solid"],"unicode":"f143","label":"RSS Square","free":["solid"],"class":"rss-square"},{"search":{"terms":["currency","money","rub"]},"styles":["solid"],"unicode":"f158","label":"Ruble Sign","free":["solid"],"class":"ruble-sign"},{"search":{"terms":["design","draft","length","measure","planning"]},"styles":["solid"],"unicode":"f545","label":"Ruler","free":["solid"],"class":"ruler"},{"search":{"terms":["design","draft","length","measure","planning"]},"styles":["solid"],"unicode":"f546","label":"Ruler Combined","free":["solid"],"class":"ruler-combined"},{"search":{"terms":["design","draft","length","measure","planning"]},"styles":["solid"],"unicode":"f547","label":"Ruler Horizontal","free":["solid"],"class":"ruler-horizontal"},{"search":{"terms":["design","draft","length","measure","planning"]},"styles":["solid"],"unicode":"f548","label":"Ruler Vertical","free":["solid"],"class":"ruler-vertical"},{"search":{"terms":["exercise","health","jog","person","run","sport","sprint"]},"styles":["solid"],"unicode":"f70c","label":"Running","free":["solid"],"class":"running"},{"search":{"terms":["currency","indian","inr","money"]},"styles":["solid"],"unicode":"f156","label":"Indian Rupee Sign","free":["solid"],"class":"rupee-sign"},{"search":{"terms":["emoticon","face","tear","tears"]},"styles":["solid","regular"],"unicode":"f5b3","label":"Crying Face","free":["solid","regular"],"class":"sad-cry"},{"search":{"terms":["emoticon","face","tear","tears"]},"styles":["solid","regular"],"unicode":"f5b4","label":"Loudly Crying Face","free":["solid","regular"],"class":"sad-tear"},{"search":{"terms":["browser"]},"styles":["brands"],"unicode":"f267","label":"Safari","free":["brands"],"class":"safari"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f83b","label":"Salesforce","free":["brands"],"class":"salesforce"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f41e","label":"Sass","free":["brands"],"class":"sass"},{"search":{"terms":["communications","hardware","orbit","space"]},"styles":["solid"],"unicode":"f7bf","label":"Satellite","free":["solid"],"class":"satellite"},{"search":{"terms":["SETI","communications","hardware","receiver","saucer","signal"]},"styles":["solid"],"unicode":"f7c0","label":"Satellite Dish","free":["solid"],"class":"satellite-dish"},{"search":{"terms":["disk","download","floppy","floppy-o"]},"styles":["solid","regular"],"unicode":"f0c7","label":"Save","free":["solid","regular"],"class":"save"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ea","label":"SCHLIX","free":["brands"],"class":"schlix"},{"search":{"terms":["building","education","learn","student","teacher"]},"styles":["solid"],"unicode":"f549","label":"School","free":["solid"],"class":"school"},{"search":{"terms":["admin","fix","mechanic","repair","settings","tool"]},"styles":["solid"],"unicode":"f54a","label":"Screwdriver","free":["solid"],"class":"screwdriver"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f28a","label":"Scribd","free":["brands"],"class":"scribd"},{"search":{"terms":["Dungeons & Dragons","announcement","d&d","dnd","fantasy","paper","script"]},"styles":["solid"],"unicode":"f70e","label":"Scroll","free":["solid"],"class":"scroll"},{"search":{"terms":["image","memory","photo","save"]},"styles":["solid"],"unicode":"f7c2","label":"Sd Card","free":["solid"],"class":"sd-card"},{"search":{"terms":["bigger","enlarge","find","magnify","preview","zoom"]},"styles":["solid"],"unicode":"f002","label":"Search","free":["solid"],"class":"search"},{"search":{"terms":["bigger","enlarge","find","magnify","money","preview","zoom"]},"styles":["solid"],"unicode":"f688","label":"Search Dollar","free":["solid"],"class":"search-dollar"},{"search":{"terms":["bigger","enlarge","find","magnify","preview","zoom"]},"styles":["solid"],"unicode":"f689","label":"Search Location","free":["solid"],"class":"search-location"},{"search":{"terms":["minify","negative","smaller","zoom","zoom out"]},"styles":["solid"],"unicode":"f010","label":"Search Minus","free":["solid"],"class":"search-minus"},{"search":{"terms":["bigger","enlarge","magnify","positive","zoom","zoom in"]},"styles":["solid"],"unicode":"f00e","label":"Search Plus","free":["solid"],"class":"search-plus"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3eb","label":"Searchengin","free":["brands"],"class":"searchengin"},{"search":{"terms":["flora","grow","plant","vegan"]},"styles":["solid"],"unicode":"f4d8","label":"Seedling","free":["solid"],"class":"seedling"},{"search":{"terms":["eercast"]},"styles":["brands"],"unicode":"f2da","label":"Sellcast","free":["brands"],"class":"sellcast"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f213","label":"Sellsy","free":["brands"],"class":"sellsy"},{"search":{"terms":["computer","cpu","database","hardware","network"]},"styles":["solid"],"unicode":"f233","label":"Server","free":["solid"],"class":"server"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ec","label":"Servicestack","free":["brands"],"class":"servicestack"},{"search":{"terms":["blocks","build","circle","square","triangle"]},"styles":["solid"],"unicode":"f61f","label":"Shapes","free":["solid"],"class":"shapes"},{"search":{"terms":["forward","save","send","social"]},"styles":["solid"],"unicode":"f064","label":"Share","free":["solid"],"class":"share"},{"search":{"terms":["forward","save","send","social"]},"styles":["solid"],"unicode":"f1e0","label":"Alternate Share","free":["solid"],"class":"share-alt"},{"search":{"terms":["forward","save","send","social"]},"styles":["solid"],"unicode":"f1e1","label":"Alternate Share Square","free":["solid"],"class":"share-alt-square"},{"search":{"terms":["forward","save","send","social"]},"styles":["solid","regular"],"unicode":"f14d","label":"Share Square","free":["solid","regular"],"class":"share-square"},{"search":{"terms":["currency","ils","money"]},"styles":["solid"],"unicode":"f20b","label":"Shekel Sign","free":["solid"],"class":"shekel-sign"},{"search":{"terms":["achievement","award","block","defend","security","winner"]},"styles":["solid"],"unicode":"f3ed","label":"Alternate Shield","free":["solid"],"class":"shield-alt"},{"search":{"terms":["boat","sea","water"]},"styles":["solid"],"unicode":"f21a","label":"Ship","free":["solid"],"class":"ship"},{"search":{"terms":["express","fedex","mail","overnight","package","ups"]},"styles":["solid"],"unicode":"f48b","label":"Shipping Fast","free":["solid"],"class":"shipping-fast"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f214","label":"Shirts in Bulk","free":["brands"],"class":"shirtsinbulk"},{"search":{"terms":["feet","footprints","steps","walk"]},"styles":["solid"],"unicode":"f54b","label":"Shoe Prints","free":["solid"],"class":"shoe-prints"},{"search":{"terms":["buy","checkout","grocery","payment","purchase"]},"styles":["solid"],"unicode":"f290","label":"Shopping Bag","free":["solid"],"class":"shopping-bag"},{"search":{"terms":["buy","checkout","grocery","payment","purchase"]},"styles":["solid"],"unicode":"f291","label":"Shopping Basket","free":["solid"],"class":"shopping-basket"},{"search":{"terms":["buy","checkout","grocery","payment","purchase"]},"styles":["solid"],"unicode":"f07a","label":"shopping-cart","free":["solid"],"class":"shopping-cart"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5b5","label":"Shopware","free":["brands"],"class":"shopware"},{"search":{"terms":["bath","clean","faucet","water"]},"styles":["solid"],"unicode":"f2cc","label":"Shower","free":["solid"],"class":"shower"},{"search":{"terms":["airport","machine","public-transportation","transportation","travel","vehicle"]},"styles":["solid"],"unicode":"f5b6","label":"Shuttle Van","free":["solid"],"class":"shuttle-van"},{"search":{"terms":["directions","real estate","signage","wayfinding"]},"styles":["solid"],"unicode":"f4d9","label":"Sign","free":["solid"],"class":"sign"},{"search":{"terms":["arrow","enter","join","log in","login","sign in","sign up","sign-in","signin","signup"]},"styles":["solid"],"unicode":"f2f6","label":"Alternate Sign In","free":["solid"],"class":"sign-in-alt"},{"search":{"terms":["Translate","asl","deaf","hands"]},"styles":["solid"],"unicode":"f2a7","label":"Sign Language","free":["solid"],"class":"sign-language"},{"search":{"terms":["arrow","exit","leave","log out","logout","sign-out"]},"styles":["solid"],"unicode":"f2f5","label":"Alternate Sign Out","free":["solid"],"class":"sign-out-alt"},{"search":{"terms":["bars","graph","online","reception","status"]},"styles":["solid"],"unicode":"f012","label":"signal","free":["solid"],"class":"signal"},{"search":{"terms":["John Hancock","cursive","name","writing"]},"styles":["solid"],"unicode":"f5b7","label":"Signature","free":["solid"],"class":"signature"},{"search":{"terms":["hard drive","hardware","portable","storage","technology","tiny"]},"styles":["solid"],"unicode":"f7c4","label":"SIM Card","free":["solid"],"class":"sim-card"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f215","label":"SimplyBuilt","free":["brands"],"class":"simplybuilt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3ee","label":"SISTRIX","free":["brands"],"class":"sistrix"},{"search":{"terms":["directory","hierarchy","ia","information architecture","organization"]},"styles":["solid"],"unicode":"f0e8","label":"Sitemap","free":["solid"],"class":"sitemap"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f512","label":"Sith","free":["brands"],"class":"sith"},{"search":{"terms":["activity","figure skating","fitness","ice","person","winter"]},"styles":["solid"],"unicode":"f7c5","label":"Skating","free":["solid"],"class":"skating"},{"search":{"terms":["app","design","interface"]},"styles":["brands"],"unicode":"f7c6","label":"Sketch","free":["brands"],"class":"sketch"},{"search":{"terms":["activity","downhill","fast","fitness","olympics","outdoors","person","seasonal","slalom"]},"styles":["solid"],"unicode":"f7c9","label":"Skiing","free":["solid"],"class":"skiing"},{"search":{"terms":["activity","cross country","fitness","outdoors","person","seasonal"]},"styles":["solid"],"unicode":"f7ca","label":"Skiing Nordic","free":["solid"],"class":"skiing-nordic"},{"search":{"terms":["bones","skeleton","x-ray","yorick"]},"styles":["solid"],"unicode":"f54c","label":"Skull","free":["solid"],"class":"skull"},{"search":{"terms":["Dungeons & Dragons","alert","bones","d&d","danger","dead","deadly","death","dnd","fantasy","halloween","holiday","jolly-roger","pirate","poison","skeleton","warning"]},"styles":["solid"],"unicode":"f714","label":"Skull & Crossbones","free":["solid"],"class":"skull-crossbones"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f216","label":"skyatlas","free":["brands"],"class":"skyatlas"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f17e","label":"Skype","free":["brands"],"class":"skype"},{"search":{"terms":["anchor","hash","hashtag"]},"styles":["brands"],"unicode":"f198","label":"Slack Logo","free":["brands"],"class":"slack"},{"search":{"terms":["anchor","hash","hashtag"]},"styles":["brands"],"unicode":"f3ef","label":"Slack Hashtag","free":["brands"],"class":"slack-hash"},{"search":{"terms":["cancel","close","mute","off","stop","x"]},"styles":["solid"],"unicode":"f715","label":"Slash","free":["solid"],"class":"slash"},{"search":{"terms":["christmas","claus","fly","holiday","santa","sled","snow","xmas"]},"styles":["solid"],"unicode":"f7cc","label":"Sleigh","free":["solid"],"class":"sleigh"},{"search":{"terms":["adjust","settings","sliders","toggle"]},"styles":["solid"],"unicode":"f1de","label":"Horizontal Sliders","free":["solid"],"class":"sliders-h"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1e7","label":"Slideshare","free":["brands"],"class":"slideshare"},{"search":{"terms":["approve","emoticon","face","happy","rating","satisfied"]},"styles":["solid","regular"],"unicode":"f118","label":"Smiling Face","free":["solid","regular"],"class":"smile"},{"search":{"terms":["emoticon","face","happy","positive"]},"styles":["solid","regular"],"unicode":"f5b8","label":"Beaming Face With Smiling Eyes","free":["solid","regular"],"class":"smile-beam"},{"search":{"terms":["emoticon","face","happy","hint","joke"]},"styles":["solid","regular"],"unicode":"f4da","label":"Winking Face","free":["solid","regular"],"class":"smile-wink"},{"search":{"terms":["dragon","fog","haze","pollution","smoke","weather"]},"styles":["solid"],"unicode":"f75f","label":"Smog","free":["solid"],"class":"smog"},{"search":{"terms":["cancer","cigarette","nicotine","smoking status","tobacco"]},"styles":["solid"],"unicode":"f48d","label":"Smoking","free":["solid"],"class":"smoking"},{"search":{"terms":["ban","cancel","no smoking","non-smoking"]},"styles":["solid"],"unicode":"f54d","label":"Smoking Ban","free":["solid"],"class":"smoking-ban"},{"search":{"terms":["chat","conversation","message","mobile","notification","phone","sms","texting"]},"styles":["solid"],"unicode":"f7cd","label":"SMS","free":["solid"],"class":"sms"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2ab","label":"Snapchat","free":["brands"],"class":"snapchat"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2ac","label":"Snapchat Ghost","free":["brands"],"class":"snapchat-ghost"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2ad","label":"Snapchat Square","free":["brands"],"class":"snapchat-square"},{"search":{"terms":["activity","fitness","olympics","outdoors","person"]},"styles":["solid"],"unicode":"f7ce","label":"Snowboarding","free":["solid"],"class":"snowboarding"},{"search":{"terms":["precipitation","rain","winter"]},"styles":["solid","regular"],"unicode":"f2dc","label":"Snowflake","free":["solid","regular"],"class":"snowflake"},{"search":{"terms":["decoration","frost","frosty","holiday"]},"styles":["solid"],"unicode":"f7d0","label":"Snowman","free":["solid"],"class":"snowman"},{"search":{"terms":["clean up","cold","road","storm","winter"]},"styles":["solid"],"unicode":"f7d2","label":"Snowplow","free":["solid"],"class":"snowplow"},{"search":{"terms":["business socks","business time","clothing","feet","flight of the conchords","wednesday"]},"styles":["solid"],"unicode":"f696","label":"Socks","free":["solid"],"class":"socks"},{"search":{"terms":["clean","eco-friendly","energy","green","sun"]},"styles":["solid"],"unicode":"f5ba","label":"Solar Panel","free":["solid"],"class":"solar-panel"},{"search":{"terms":["filter","order"]},"styles":["solid"],"unicode":"f0dc","label":"Sort","free":["solid"],"class":"sort"},{"search":{"terms":["alphabetical","arrange","filter","order","sort-alpha-asc"]},"styles":["solid"],"unicode":"f15d","label":"Sort Alphabetical Down","free":["solid"],"class":"sort-alpha-down"},{"search":{"terms":["alphabetical","arrange","filter","order","sort-alpha-asc"]},"styles":["solid"],"unicode":"f881","label":"Alternate Sort Alphabetical Down","free":["solid"],"class":"sort-alpha-down-alt"},{"search":{"terms":["alphabetical","arrange","filter","order","sort-alpha-desc"]},"styles":["solid"],"unicode":"f15e","label":"Sort Alphabetical Up","free":["solid"],"class":"sort-alpha-up"},{"search":{"terms":["alphabetical","arrange","filter","order","sort-alpha-desc"]},"styles":["solid"],"unicode":"f882","label":"Alternate Sort Alphabetical Up","free":["solid"],"class":"sort-alpha-up-alt"},{"search":{"terms":["arrange","filter","number","order","sort-amount-asc"]},"styles":["solid"],"unicode":"f160","label":"Sort Amount Down","free":["solid"],"class":"sort-amount-down"},{"search":{"terms":["arrange","filter","order","sort-amount-asc"]},"styles":["solid"],"unicode":"f884","label":"Alternate Sort Amount Down","free":["solid"],"class":"sort-amount-down-alt"},{"search":{"terms":["arrange","filter","order","sort-amount-desc"]},"styles":["solid"],"unicode":"f161","label":"Sort Amount Up","free":["solid"],"class":"sort-amount-up"},{"search":{"terms":["arrange","filter","order","sort-amount-desc"]},"styles":["solid"],"unicode":"f885","label":"Alternate Sort Amount Up","free":["solid"],"class":"sort-amount-up-alt"},{"search":{"terms":["arrow","descending","filter","order","sort-desc"]},"styles":["solid"],"unicode":"f0dd","label":"Sort Down (Descending)","free":["solid"],"class":"sort-down"},{"search":{"terms":["arrange","filter","numbers","order","sort-numeric-asc"]},"styles":["solid"],"unicode":"f162","label":"Sort Numeric Down","free":["solid"],"class":"sort-numeric-down"},{"search":{"terms":["arrange","filter","numbers","order","sort-numeric-asc"]},"styles":["solid"],"unicode":"f886","label":"Alternate Sort Numeric Down","free":["solid"],"class":"sort-numeric-down-alt"},{"search":{"terms":["arrange","filter","numbers","order","sort-numeric-desc"]},"styles":["solid"],"unicode":"f163","label":"Sort Numeric Up","free":["solid"],"class":"sort-numeric-up"},{"search":{"terms":["arrange","filter","numbers","order","sort-numeric-desc"]},"styles":["solid"],"unicode":"f887","label":"Alternate Sort Numeric Up","free":["solid"],"class":"sort-numeric-up-alt"},{"search":{"terms":["arrow","ascending","filter","order","sort-asc"]},"styles":["solid"],"unicode":"f0de","label":"Sort Up (Ascending)","free":["solid"],"class":"sort-up"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1be","label":"SoundCloud","free":["brands"],"class":"soundcloud"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f7d3","label":"Sourcetree","free":["brands"],"class":"sourcetree"},{"search":{"terms":["flora","massage","mindfulness","plant","wellness"]},"styles":["solid"],"unicode":"f5bb","label":"Spa","free":["solid"],"class":"spa"},{"search":{"terms":["astronaut","machine","nasa","rocket","transportation"]},"styles":["solid"],"unicode":"f197","label":"Space Shuttle","free":["solid"],"class":"space-shuttle"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3f3","label":"Speakap","free":["brands"],"class":"speakap"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f83c","label":"Speaker Deck","free":["brands"],"class":"speaker-deck"},{"search":{"terms":["dictionary","edit","editor","grammar","text"]},"styles":["solid"],"unicode":"f891","label":"Spell Check","free":["solid"],"class":"spell-check"},{"search":{"terms":["arachnid","bug","charlotte","crawl","eight","halloween"]},"styles":["solid"],"unicode":"f717","label":"Spider","free":["solid"],"class":"spider"},{"search":{"terms":["circle","loading","progress"]},"styles":["solid"],"unicode":"f110","label":"Spinner","free":["solid"],"class":"spinner"},{"search":{"terms":["Ink","blob","blotch","glob","stain"]},"styles":["solid"],"unicode":"f5bc","label":"Splotch","free":["solid"],"class":"splotch"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1bc","label":"Spotify","free":["brands"],"class":"spotify"},{"search":{"terms":["Paint","aerosol","design","graffiti","tag"]},"styles":["solid"],"unicode":"f5bd","label":"Spray Can","free":["solid"],"class":"spray-can"},{"search":{"terms":["block","box","shape"]},"styles":["solid","regular"],"unicode":"f0c8","label":"Square","free":["solid","regular"],"class":"square"},{"search":{"terms":["block","box","shape"]},"styles":["solid"],"unicode":"f45c","label":"Square Full","free":["solid"],"class":"square-full"},{"search":{"terms":["arithmetic","calculus","division","math"]},"styles":["solid"],"unicode":"f698","label":"Alternate Square Root","free":["solid"],"class":"square-root-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5be","label":"Squarespace","free":["brands"],"class":"squarespace"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f18d","label":"Stack Exchange","free":["brands"],"class":"stack-exchange"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f16c","label":"Stack Overflow","free":["brands"],"class":"stack-overflow"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f842","label":"Stackpath","free":["brands"],"class":"stackpath"},{"search":{"terms":["art","certificate","imprint","rubber","seal"]},"styles":["solid"],"unicode":"f5bf","label":"Stamp","free":["solid"],"class":"stamp"},{"search":{"terms":["achievement","award","favorite","important","night","rating","score"]},"styles":["solid","regular"],"unicode":"f005","label":"Star","free":["solid","regular"],"class":"star"},{"search":{"terms":["islam","muslim","religion"]},"styles":["solid"],"unicode":"f699","label":"Star and Crescent","free":["solid"],"class":"star-and-crescent"},{"search":{"terms":["achievement","award","rating","score","star-half-empty","star-half-full"]},"styles":["solid","regular"],"unicode":"f089","label":"star-half","free":["solid","regular"],"class":"star-half"},{"search":{"terms":["achievement","award","rating","score","star-half-empty","star-half-full"]},"styles":["solid"],"unicode":"f5c0","label":"Alternate Star Half","free":["solid"],"class":"star-half-alt"},{"search":{"terms":["jewish","judaism","religion"]},"styles":["solid"],"unicode":"f69a","label":"Star of David","free":["solid"],"class":"star-of-david"},{"search":{"terms":["doctor","emt","first aid","health","medical"]},"styles":["solid"],"unicode":"f621","label":"Star of Life","free":["solid"],"class":"star-of-life"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3f5","label":"StayLinked","free":["brands"],"class":"staylinked"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1b6","label":"Steam","free":["brands"],"class":"steam"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1b7","label":"Steam Square","free":["brands"],"class":"steam-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3f6","label":"Steam Symbol","free":["brands"],"class":"steam-symbol"},{"search":{"terms":["beginning","first","previous","rewind","start"]},"styles":["solid"],"unicode":"f048","label":"step-backward","free":["solid"],"class":"step-backward"},{"search":{"terms":["end","last","next"]},"styles":["solid"],"unicode":"f051","label":"step-forward","free":["solid"],"class":"step-forward"},{"search":{"terms":["diagnosis","doctor","general practitioner","hospital","infirmary","medicine","office","outpatient"]},"styles":["solid"],"unicode":"f0f1","label":"Stethoscope","free":["solid"],"class":"stethoscope"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3f7","label":"Sticker Mule","free":["brands"],"class":"sticker-mule"},{"search":{"terms":["message","note","paper","reminder","sticker"]},"styles":["solid","regular"],"unicode":"f249","label":"Sticky Note","free":["solid","regular"],"class":"sticky-note"},{"search":{"terms":["block","box","square"]},"styles":["solid"],"unicode":"f04d","label":"stop","free":["solid"],"class":"stop"},{"search":{"terms":["block","box","circle","square"]},"styles":["solid","regular"],"unicode":"f28d","label":"Stop Circle","free":["solid","regular"],"class":"stop-circle"},{"search":{"terms":["clock","reminder","time"]},"styles":["solid"],"unicode":"f2f2","label":"Stopwatch","free":["solid"],"class":"stopwatch"},{"search":{"terms":["building","buy","purchase","shopping"]},"styles":["solid"],"unicode":"f54e","label":"Store","free":["solid"],"class":"store"},{"search":{"terms":["building","buy","purchase","shopping"]},"styles":["solid"],"unicode":"f54f","label":"Alternate Store","free":["solid"],"class":"store-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f428","label":"Strava","free":["brands"],"class":"strava"},{"search":{"terms":["flow","list","timeline"]},"styles":["solid"],"unicode":"f550","label":"Stream","free":["solid"],"class":"stream"},{"search":{"terms":["directions","location","map","navigation"]},"styles":["solid"],"unicode":"f21d","label":"Street View","free":["solid"],"class":"street-view"},{"search":{"terms":["cancel","edit","font","format","text","type"]},"styles":["solid"],"unicode":"f0cc","label":"Strikethrough","free":["solid"],"class":"strikethrough"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f429","label":"Stripe","free":["brands"],"class":"stripe"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f42a","label":"Stripe S","free":["brands"],"class":"stripe-s"},{"search":{"terms":["caramel","cookie","dessert","sweets","waffle"]},"styles":["solid"],"unicode":"f551","label":"Stroopwafel","free":["solid"],"class":"stroopwafel"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3f8","label":"Studio Vinari","free":["brands"],"class":"studiovinari"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a4","label":"StumbleUpon Logo","free":["brands"],"class":"stumbleupon"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1a3","label":"StumbleUpon Circle","free":["brands"],"class":"stumbleupon-circle"},{"search":{"terms":["edit","font","format","text","type"]},"styles":["solid"],"unicode":"f12c","label":"subscript","free":["solid"],"class":"subscript"},{"search":{"terms":["machine","railway","train","transportation","vehicle"]},"styles":["solid"],"unicode":"f239","label":"Subway","free":["solid"],"class":"subway"},{"search":{"terms":["baggage","luggage","move","suitcase","travel","trip"]},"styles":["solid"],"unicode":"f0f2","label":"Suitcase","free":["solid"],"class":"suitcase"},{"search":{"terms":["baggage","luggage","move","suitcase","travel","trip"]},"styles":["solid"],"unicode":"f5c1","label":"Suitcase Rolling","free":["solid"],"class":"suitcase-rolling"},{"search":{"terms":["brighten","contrast","day","lighter","sol","solar","star","weather"]},"styles":["solid","regular"],"unicode":"f185","label":"Sun","free":["solid","regular"],"class":"sun"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2dd","label":"Superpowers","free":["brands"],"class":"superpowers"},{"search":{"terms":["edit","exponential","font","format","text","type"]},"styles":["solid"],"unicode":"f12b","label":"superscript","free":["solid"],"class":"superscript"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3f9","label":"Supple","free":["brands"],"class":"supple"},{"search":{"terms":["emoticon","face","shocked"]},"styles":["solid","regular"],"unicode":"f5c2","label":"Hushed Face","free":["solid","regular"],"class":"surprise"},{"search":{"terms":["linux","operating system","os"]},"styles":["brands"],"unicode":"f7d6","label":"Suse","free":["brands"],"class":"suse"},{"search":{"terms":["Pantone","color","design","hue","palette"]},"styles":["solid"],"unicode":"f5c3","label":"Swatchbook","free":["solid"],"class":"swatchbook"},{"search":{"terms":["athlete","head","man","olympics","person","pool","water"]},"styles":["solid"],"unicode":"f5c4","label":"Swimmer","free":["solid"],"class":"swimmer"},{"search":{"terms":["ladder","recreation","swim","water"]},"styles":["solid"],"unicode":"f5c5","label":"Swimming Pool","free":["solid"],"class":"swimming-pool"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f83d","label":"Symfony","free":["brands"],"class":"symfony"},{"search":{"terms":["building","jewish","judaism","religion","star of david","temple"]},"styles":["solid"],"unicode":"f69b","label":"Synagogue","free":["solid"],"class":"synagogue"},{"search":{"terms":["exchange","refresh","reload","rotate","swap"]},"styles":["solid"],"unicode":"f021","label":"Sync","free":["solid"],"class":"sync"},{"search":{"terms":["exchange","refresh","reload","rotate","swap"]},"styles":["solid"],"unicode":"f2f1","label":"Alternate Sync","free":["solid"],"class":"sync-alt"},{"search":{"terms":["doctor","immunizations","medical","needle"]},"styles":["solid"],"unicode":"f48e","label":"Syringe","free":["solid"],"class":"syringe"},{"search":{"terms":["data","excel","spreadsheet"]},"styles":["solid"],"unicode":"f0ce","label":"table","free":["solid"],"class":"table"},{"search":{"terms":["ball","paddle","ping pong"]},"styles":["solid"],"unicode":"f45d","label":"Table Tennis","free":["solid"],"class":"table-tennis"},{"search":{"terms":["apple","device","ipad","kindle","screen"]},"styles":["solid"],"unicode":"f10a","label":"tablet","free":["solid"],"class":"tablet"},{"search":{"terms":["apple","device","ipad","kindle","screen"]},"styles":["solid"],"unicode":"f3fa","label":"Alternate Tablet","free":["solid"],"class":"tablet-alt"},{"search":{"terms":["drugs","medicine","pills","prescription"]},"styles":["solid"],"unicode":"f490","label":"Tablets","free":["solid"],"class":"tablets"},{"search":{"terms":["dashboard","fast","odometer","speed","speedometer"]},"styles":["solid"],"unicode":"f3fd","label":"Alternate Tachometer","free":["solid"],"class":"tachometer-alt"},{"search":{"terms":["discount","label","price","shopping"]},"styles":["solid"],"unicode":"f02b","label":"tag","free":["solid"],"class":"tag"},{"search":{"terms":["discount","label","price","shopping"]},"styles":["solid"],"unicode":"f02c","label":"tags","free":["solid"],"class":"tags"},{"search":{"terms":["design","package","sticky"]},"styles":["solid"],"unicode":"f4db","label":"Tape","free":["solid"],"class":"tape"},{"search":{"terms":["checklist","downloading","downloads","loading","progress","project management","settings","to do"]},"styles":["solid"],"unicode":"f0ae","label":"Tasks","free":["solid"],"class":"tasks"},{"search":{"terms":["cab","cabbie","car","car service","lyft","machine","transportation","travel","uber","vehicle"]},"styles":["solid"],"unicode":"f1ba","label":"Taxi","free":["solid"],"class":"taxi"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f4f9","label":"TeamSpeak","free":["brands"],"class":"teamspeak"},{"search":{"terms":["bite","dental","dentist","gums","mouth","smile","tooth"]},"styles":["solid"],"unicode":"f62e","label":"Teeth","free":["solid"],"class":"teeth"},{"search":{"terms":["dental","dentist","gums bite","mouth","smile","tooth"]},"styles":["solid"],"unicode":"f62f","label":"Teeth Open","free":["solid"],"class":"teeth-open"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2c6","label":"Telegram","free":["brands"],"class":"telegram"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f3fe","label":"Telegram Plane","free":["brands"],"class":"telegram-plane"},{"search":{"terms":["cook","mercury","summer","thermometer","warm"]},"styles":["solid"],"unicode":"f769","label":"High Temperature","free":["solid"],"class":"temperature-high"},{"search":{"terms":["cold","cool","mercury","thermometer","winter"]},"styles":["solid"],"unicode":"f76b","label":"Low Temperature","free":["solid"],"class":"temperature-low"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1d5","label":"Tencent Weibo","free":["brands"],"class":"tencent-weibo"},{"search":{"terms":["currency","kazakhstan","money","price"]},"styles":["solid"],"unicode":"f7d7","label":"Tenge","free":["solid"],"class":"tenge"},{"search":{"terms":["code","command","console","development","prompt"]},"styles":["solid"],"unicode":"f120","label":"Terminal","free":["solid"],"class":"terminal"},{"search":{"terms":["edit","font","format","text","type"]},"styles":["solid"],"unicode":"f034","label":"text-height","free":["solid"],"class":"text-height"},{"search":{"terms":["edit","font","format","text","type"]},"styles":["solid"],"unicode":"f035","label":"Text Width","free":["solid"],"class":"text-width"},{"search":{"terms":["blocks","boxes","grid","squares"]},"styles":["solid"],"unicode":"f00a","label":"th","free":["solid"],"class":"th"},{"search":{"terms":["blocks","boxes","grid","squares"]},"styles":["solid"],"unicode":"f009","label":"th-large","free":["solid"],"class":"th-large"},{"search":{"terms":["checklist","completed","done","finished","ol","todo","ul"]},"styles":["solid"],"unicode":"f00b","label":"th-list","free":["solid"],"class":"th-list"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f69d","label":"The Red Yeti","free":["brands"],"class":"the-red-yeti"},{"search":{"terms":["comedy","perform","theatre","tragedy"]},"styles":["solid"],"unicode":"f630","label":"Theater Masks","free":["solid"],"class":"theater-masks"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5c6","label":"Themeco","free":["brands"],"class":"themeco"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2b2","label":"ThemeIsle","free":["brands"],"class":"themeisle"},{"search":{"terms":["mercury","status","temperature"]},"styles":["solid"],"unicode":"f491","label":"Thermometer","free":["solid"],"class":"thermometer"},{"search":{"terms":["cold","mercury","status","temperature"]},"styles":["solid"],"unicode":"f2cb","label":"Thermometer Empty","free":["solid"],"class":"thermometer-empty"},{"search":{"terms":["fever","hot","mercury","status","temperature"]},"styles":["solid"],"unicode":"f2c7","label":"Thermometer Full","free":["solid"],"class":"thermometer-full"},{"search":{"terms":["mercury","status","temperature"]},"styles":["solid"],"unicode":"f2c9","label":"Thermometer 1/2 Full","free":["solid"],"class":"thermometer-half"},{"search":{"terms":["mercury","status","temperature"]},"styles":["solid"],"unicode":"f2ca","label":"Thermometer 1/4 Full","free":["solid"],"class":"thermometer-quarter"},{"search":{"terms":["mercury","status","temperature"]},"styles":["solid"],"unicode":"f2c8","label":"Thermometer 3/4 Full","free":["solid"],"class":"thermometer-three-quarters"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f731","label":"Think Peaks","free":["brands"],"class":"think-peaks"},{"search":{"terms":["disagree","disapprove","dislike","hand","social","thumbs-o-down"]},"styles":["solid","regular"],"unicode":"f165","label":"thumbs-down","free":["solid","regular"],"class":"thumbs-down"},{"search":{"terms":["agree","approve","favorite","hand","like","ok","okay","social","success","thumbs-o-up","yes","you got it dude"]},"styles":["solid","regular"],"unicode":"f164","label":"thumbs-up","free":["solid","regular"],"class":"thumbs-up"},{"search":{"terms":["coordinates","location","marker","pin","thumb-tack"]},"styles":["solid"],"unicode":"f08d","label":"Thumbtack","free":["solid"],"class":"thumbtack"},{"search":{"terms":["movie","pass","support","ticket"]},"styles":["solid"],"unicode":"f3ff","label":"Alternate Ticket","free":["solid"],"class":"ticket-alt"},{"search":{"terms":["close","cross","error","exit","incorrect","notice","notification","notify","problem","wrong","x"]},"styles":["solid"],"unicode":"f00d","label":"Times","free":["solid"],"class":"times"},{"search":{"terms":["close","cross","exit","incorrect","notice","notification","notify","problem","wrong","x"]},"styles":["solid","regular"],"unicode":"f057","label":"Times Circle","free":["solid","regular"],"class":"times-circle"},{"search":{"terms":["color","drop","droplet","raindrop","waterdrop"]},"styles":["solid"],"unicode":"f043","label":"tint","free":["solid"],"class":"tint"},{"search":{"terms":["color","drop","droplet","raindrop","waterdrop"]},"styles":["solid"],"unicode":"f5c7","label":"Tint Slash","free":["solid"],"class":"tint-slash"},{"search":{"terms":["angry","emoticon","face","grumpy","upset"]},"styles":["solid","regular"],"unicode":"f5c8","label":"Tired Face","free":["solid","regular"],"class":"tired"},{"search":{"terms":["switch"]},"styles":["solid"],"unicode":"f204","label":"Toggle Off","free":["solid"],"class":"toggle-off"},{"search":{"terms":["switch"]},"styles":["solid"],"unicode":"f205","label":"Toggle On","free":["solid"],"class":"toggle-on"},{"search":{"terms":["bathroom","flush","john","loo","pee","plumbing","poop","porcelain","potty","restroom","throne","washroom","waste","wc"]},"styles":["solid"],"unicode":"f7d8","label":"Toilet","free":["solid"],"class":"toilet"},{"search":{"terms":["bathroom","halloween","holiday","lavatory","prank","restroom","roll"]},"styles":["solid"],"unicode":"f71e","label":"Toilet Paper","free":["solid"],"class":"toilet-paper"},{"search":{"terms":["admin","container","fix","repair","settings","tools"]},"styles":["solid"],"unicode":"f552","label":"Toolbox","free":["solid"],"class":"toolbox"},{"search":{"terms":["admin","fix","repair","screwdriver","settings","tools","wrench"]},"styles":["solid"],"unicode":"f7d9","label":"Tools","free":["solid"],"class":"tools"},{"search":{"terms":["bicuspid","dental","dentist","molar","mouth","teeth"]},"styles":["solid"],"unicode":"f5c9","label":"Tooth","free":["solid"],"class":"tooth"},{"search":{"terms":["book","jewish","judaism","religion","scroll"]},"styles":["solid"],"unicode":"f6a0","label":"Torah","free":["solid"],"class":"torah"},{"search":{"terms":["building","shintoism"]},"styles":["solid"],"unicode":"f6a1","label":"Torii Gate","free":["solid"],"class":"torii-gate"},{"search":{"terms":["agriculture","farm","vehicle"]},"styles":["solid"],"unicode":"f722","label":"Tractor","free":["solid"],"class":"tractor"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f513","label":"Trade Federation","free":["brands"],"class":"trade-federation"},{"search":{"terms":["copyright","register","symbol"]},"styles":["solid"],"unicode":"f25c","label":"Trademark","free":["solid"],"class":"trademark"},{"search":{"terms":["direction","road","signal","travel"]},"styles":["solid"],"unicode":"f637","label":"Traffic Light","free":["solid"],"class":"traffic-light"},{"search":{"terms":["bullet","commute","locomotive","railway","subway"]},"styles":["solid"],"unicode":"f238","label":"Train","free":["solid"],"class":"train"},{"search":{"terms":["crossing","machine","mountains","seasonal","transportation"]},"styles":["solid"],"unicode":"f7da","label":"Tram","free":["solid"],"class":"tram"},{"search":{"terms":["intersex"]},"styles":["solid"],"unicode":"f224","label":"Transgender","free":["solid"],"class":"transgender"},{"search":{"terms":["intersex"]},"styles":["solid"],"unicode":"f225","label":"Alternate Transgender","free":["solid"],"class":"transgender-alt"},{"search":{"terms":["delete","garbage","hide","remove"]},"styles":["solid"],"unicode":"f1f8","label":"Trash","free":["solid"],"class":"trash"},{"search":{"terms":["delete","garbage","hide","remove","trash-o"]},"styles":["solid","regular"],"unicode":"f2ed","label":"Alternate Trash","free":["solid","regular"],"class":"trash-alt"},{"search":{"terms":["back","control z","oops","undo"]},"styles":["solid"],"unicode":"f829","label":"Trash Restore","free":["solid"],"class":"trash-restore"},{"search":{"terms":["back","control z","oops","undo"]},"styles":["solid"],"unicode":"f82a","label":"Alternative Trash Restore","free":["solid"],"class":"trash-restore-alt"},{"search":{"terms":["bark","fall","flora","forest","nature","plant","seasonal"]},"styles":["solid"],"unicode":"f1bb","label":"Tree","free":["solid"],"class":"tree"},{"search":{"terms":["atlassian"]},"styles":["brands"],"unicode":"f181","label":"Trello","free":["brands"],"class":"trello"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f262","label":"TripAdvisor","free":["brands"],"class":"tripadvisor"},{"search":{"terms":["achievement","award","cup","game","winner"]},"styles":["solid"],"unicode":"f091","label":"trophy","free":["solid"],"class":"trophy"},{"search":{"terms":["cargo","delivery","shipping","vehicle"]},"styles":["solid"],"unicode":"f0d1","label":"truck","free":["solid"],"class":"truck"},{"search":{"terms":["box","cargo","delivery","inventory","moving","rental","vehicle"]},"styles":["solid"],"unicode":"f4de","label":"Truck Loading","free":["solid"],"class":"truck-loading"},{"search":{"terms":["offroad","vehicle","wheel"]},"styles":["solid"],"unicode":"f63b","label":"Truck Monster","free":["solid"],"class":"truck-monster"},{"search":{"terms":["cargo","inventory","rental","vehicle"]},"styles":["solid"],"unicode":"f4df","label":"Truck Moving","free":["solid"],"class":"truck-moving"},{"search":{"terms":["cargo","vehicle"]},"styles":["solid"],"unicode":"f63c","label":"Truck Side","free":["solid"],"class":"truck-pickup"},{"search":{"terms":["clothing","fashion","garment","shirt"]},"styles":["solid"],"unicode":"f553","label":"T-Shirt","free":["solid"],"class":"tshirt"},{"search":{"terms":["communication","deaf","telephone","teletypewriter","text"]},"styles":["solid"],"unicode":"f1e4","label":"TTY","free":["solid"],"class":"tty"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f173","label":"Tumblr","free":["brands"],"class":"tumblr"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f174","label":"Tumblr Square","free":["brands"],"class":"tumblr-square"},{"search":{"terms":["computer","display","monitor","television"]},"styles":["solid"],"unicode":"f26c","label":"Television","free":["solid"],"class":"tv"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1e8","label":"Twitch","free":["brands"],"class":"twitch"},{"search":{"terms":["social network","tweet"]},"styles":["brands"],"unicode":"f099","label":"Twitter","free":["brands"],"class":"twitter"},{"search":{"terms":["social network","tweet"]},"styles":["brands"],"unicode":"f081","label":"Twitter Square","free":["brands"],"class":"twitter-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f42b","label":"Typo3","free":["brands"],"class":"typo3"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f402","label":"Uber","free":["brands"],"class":"uber"},{"search":{"terms":["linux","operating system","os"]},"styles":["brands"],"unicode":"f7df","label":"Ubuntu","free":["brands"],"class":"ubuntu"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f403","label":"UIkit","free":["brands"],"class":"uikit"},{"search":{"terms":["protection","rain","storm","wet"]},"styles":["solid"],"unicode":"f0e9","label":"Umbrella","free":["solid"],"class":"umbrella"},{"search":{"terms":["protection","recreation","sand","shade","summer","sun"]},"styles":["solid"],"unicode":"f5ca","label":"Umbrella Beach","free":["solid"],"class":"umbrella-beach"},{"search":{"terms":["edit","emphasis","format","text","writing"]},"styles":["solid"],"unicode":"f0cd","label":"Underline","free":["solid"],"class":"underline"},{"search":{"terms":["back","control z","exchange","oops","return","rotate","swap"]},"styles":["solid"],"unicode":"f0e2","label":"Undo","free":["solid"],"class":"undo"},{"search":{"terms":["back","control z","exchange","oops","return","swap"]},"styles":["solid"],"unicode":"f2ea","label":"Alternate Undo","free":["solid"],"class":"undo-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f404","label":"Uniregistry","free":["brands"],"class":"uniregistry"},{"search":{"terms":["accessibility","hearing","person","seeing","visual impairment"]},"styles":["solid"],"unicode":"f29a","label":"Universal Access","free":["solid"],"class":"universal-access"},{"search":{"terms":["bank","building","college","higher education - students","institution"]},"styles":["solid"],"unicode":"f19c","label":"University","free":["solid"],"class":"university"},{"search":{"terms":["attachment","chain","chain-broken","remove"]},"styles":["solid"],"unicode":"f127","label":"unlink","free":["solid"],"class":"unlink"},{"search":{"terms":["admin","lock","password","private","protect"]},"styles":["solid"],"unicode":"f09c","label":"unlock","free":["solid"],"class":"unlock"},{"search":{"terms":["admin","lock","password","private","protect"]},"styles":["solid"],"unicode":"f13e","label":"Alternate Unlock","free":["solid"],"class":"unlock-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f405","label":"Untappd","free":["brands"],"class":"untappd"},{"search":{"terms":["hard drive","import","publish"]},"styles":["solid"],"unicode":"f093","label":"Upload","free":["solid"],"class":"upload"},{"search":{"terms":["United Parcel Service","package","shipping"]},"styles":["brands"],"unicode":"f7e0","label":"UPS","free":["brands"],"class":"ups"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f287","label":"USB","free":["brands"],"class":"usb"},{"search":{"terms":["account","avatar","head","human","man","person","profile"]},"styles":["solid","regular"],"unicode":"f007","label":"User","free":["solid","regular"],"class":"user"},{"search":{"terms":["account","avatar","head","human","man","person","profile"]},"styles":["solid"],"unicode":"f406","label":"Alternate User","free":["solid"],"class":"user-alt"},{"search":{"terms":["account","avatar","head","human","man","person","profile"]},"styles":["solid"],"unicode":"f4fa","label":"Alternate User Slash","free":["solid"],"class":"user-alt-slash"},{"search":{"terms":["avatar","clothing","cosmonaut","nasa","space","suit"]},"styles":["solid"],"unicode":"f4fb","label":"User Astronaut","free":["solid"],"class":"user-astronaut"},{"search":{"terms":["accept","check","person","verified"]},"styles":["solid"],"unicode":"f4fc","label":"User Check","free":["solid"],"class":"user-check"},{"search":{"terms":["account","avatar","head","human","man","person","profile"]},"styles":["solid","regular"],"unicode":"f2bd","label":"User Circle","free":["solid","regular"],"class":"user-circle"},{"search":{"terms":["alert","person","remind","time"]},"styles":["solid"],"unicode":"f4fd","label":"User Clock","free":["solid"],"class":"user-clock"},{"search":{"terms":["admin","cog","person","settings"]},"styles":["solid"],"unicode":"f4fe","label":"User Cog","free":["solid"],"class":"user-cog"},{"search":{"terms":["edit","pen","pencil","person","update","write"]},"styles":["solid"],"unicode":"f4ff","label":"User Edit","free":["solid"],"class":"user-edit"},{"search":{"terms":["group","people","person","team","users"]},"styles":["solid"],"unicode":"f500","label":"User Friends","free":["solid"],"class":"user-friends"},{"search":{"terms":["cap","clothing","commencement","gown","graduation","person","student"]},"styles":["solid"],"unicode":"f501","label":"User Graduate","free":["solid"],"class":"user-graduate"},{"search":{"terms":["cast","injury","ouch","patient","person","sling"]},"styles":["solid"],"unicode":"f728","label":"User Injured","free":["solid"],"class":"user-injured"},{"search":{"terms":["admin","lock","person","private","unlock"]},"styles":["solid"],"unicode":"f502","label":"User Lock","free":["solid"],"class":"user-lock"},{"search":{"terms":["job","medical","nurse","occupation","physician","profile","surgeon"]},"styles":["solid"],"unicode":"f0f0","label":"Doctor","free":["solid"],"class":"user-md"},{"search":{"terms":["delete","negative","remove"]},"styles":["solid"],"unicode":"f503","label":"User Minus","free":["solid"],"class":"user-minus"},{"search":{"terms":["assassin","avatar","dangerous","deadly","sneaky"]},"styles":["solid"],"unicode":"f504","label":"User Ninja","free":["solid"],"class":"user-ninja"},{"search":{"terms":["doctor","midwife","practitioner","surgeon"]},"styles":["solid"],"unicode":"f82f","label":"Nurse","free":["solid"],"class":"user-nurse"},{"search":{"terms":["add","avatar","positive","sign up","signup","team"]},"styles":["solid"],"unicode":"f234","label":"User Plus","free":["solid"],"class":"user-plus"},{"search":{"terms":["clothing","coat","hat","incognito","person","privacy","spy","whisper"]},"styles":["solid"],"unicode":"f21b","label":"User Secret","free":["solid"],"class":"user-secret"},{"search":{"terms":["admin","person","private","protect","safe"]},"styles":["solid"],"unicode":"f505","label":"User Shield","free":["solid"],"class":"user-shield"},{"search":{"terms":["ban","delete","remove"]},"styles":["solid"],"unicode":"f506","label":"User Slash","free":["solid"],"class":"user-slash"},{"search":{"terms":["avatar","discount","label","person","role","special"]},"styles":["solid"],"unicode":"f507","label":"User Tag","free":["solid"],"class":"user-tag"},{"search":{"terms":["avatar","business","clothing","formal","professional","suit"]},"styles":["solid"],"unicode":"f508","label":"User Tie","free":["solid"],"class":"user-tie"},{"search":{"terms":["archive","delete","remove","x"]},"styles":["solid"],"unicode":"f235","label":"Remove User","free":["solid"],"class":"user-times"},{"search":{"terms":["friends","group","people","persons","profiles","team"]},"styles":["solid"],"unicode":"f0c0","label":"Users","free":["solid"],"class":"users"},{"search":{"terms":["admin","cog","group","person","settings","team"]},"styles":["solid"],"unicode":"f509","label":"Users Cog","free":["solid"],"class":"users-cog"},{"search":{"terms":["american","package","shipping","usa"]},"styles":["brands"],"unicode":"f7e1","label":"United States Postal Service","free":["brands"],"class":"usps"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f407","label":"us-Sunnah Foundation","free":["brands"],"class":"ussunnah"},{"search":{"terms":["cutlery","dining","scoop","silverware","spoon"]},"styles":["solid"],"unicode":"f2e5","label":"Utensil Spoon","free":["solid"],"class":"utensil-spoon"},{"search":{"terms":["cutlery","dining","dinner","eat","food","fork","knife","restaurant"]},"styles":["solid"],"unicode":"f2e7","label":"Utensils","free":["solid"],"class":"utensils"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f408","label":"Vaadin","free":["brands"],"class":"vaadin"},{"search":{"terms":["anchors","lines","object","render","shape"]},"styles":["solid"],"unicode":"f5cb","label":"Vector Square","free":["solid"],"class":"vector-square"},{"search":{"terms":["female"]},"styles":["solid"],"unicode":"f221","label":"Venus","free":["solid"],"class":"venus"},{"search":{"terms":["female"]},"styles":["solid"],"unicode":"f226","label":"Venus Double","free":["solid"],"class":"venus-double"},{"search":{"terms":["Gender"]},"styles":["solid"],"unicode":"f228","label":"Venus Mars","free":["solid"],"class":"venus-mars"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f237","label":"Viacoin","free":["brands"],"class":"viacoin"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2a9","label":"Video","free":["brands"],"class":"viadeo"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2aa","label":"Video Square","free":["brands"],"class":"viadeo-square"},{"search":{"terms":["experiment","lab","sample","science","test","test tube"]},"styles":["solid"],"unicode":"f492","label":"Vial","free":["solid"],"class":"vial"},{"search":{"terms":["experiment","lab","sample","science","test","test tube"]},"styles":["solid"],"unicode":"f493","label":"Vials","free":["solid"],"class":"vials"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f409","label":"Viber","free":["brands"],"class":"viber"},{"search":{"terms":["camera","film","movie","record","video-camera"]},"styles":["solid"],"unicode":"f03d","label":"Video","free":["solid"],"class":"video"},{"search":{"terms":["add","create","film","new","positive","record","video"]},"styles":["solid"],"unicode":"f4e2","label":"Video Slash","free":["solid"],"class":"video-slash"},{"search":{"terms":["buddhism","buddhist","building","monastery"]},"styles":["solid"],"unicode":"f6a7","label":"Vihara","free":["solid"],"class":"vihara"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f40a","label":"Vimeo","free":["brands"],"class":"vimeo"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f194","label":"Vimeo Square","free":["brands"],"class":"vimeo-square"},{"search":{"terms":["vimeo"]},"styles":["brands"],"unicode":"f27d","label":"Vimeo","free":["brands"],"class":"vimeo-v"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1ca","label":"Vine","free":["brands"],"class":"vine"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f189","label":"VK","free":["brands"],"class":"vk"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f40b","label":"VNV","free":["brands"],"class":"vnv"},{"search":{"terms":["answer","inbox","message","phone"]},"styles":["solid"],"unicode":"f897","label":"Voicemail","free":["solid"],"class":"voicemail"},{"search":{"terms":["beach","olympics","sport"]},"styles":["solid"],"unicode":"f45f","label":"Volleyball Ball","free":["solid"],"class":"volleyball-ball"},{"search":{"terms":["audio","lower","music","quieter","sound","speaker"]},"styles":["solid"],"unicode":"f027","label":"Volume Down","free":["solid"],"class":"volume-down"},{"search":{"terms":["audio","music","quiet","sound","speaker"]},"styles":["solid"],"unicode":"f6a9","label":"Volume Mute","free":["solid"],"class":"volume-mute"},{"search":{"terms":["audio","ban","music","mute","quiet","silent","sound"]},"styles":["solid"],"unicode":"f026","label":"Volume Off","free":["solid"],"class":"volume-off"},{"search":{"terms":["audio","higher","louder","music","sound","speaker"]},"styles":["solid"],"unicode":"f028","label":"Volume Up","free":["solid"],"class":"volume-up"},{"search":{"terms":["accept","cast","election","politics","positive","yes"]},"styles":["solid"],"unicode":"f772","label":"Vote Yea","free":["solid"],"class":"vote-yea"},{"search":{"terms":["3d","augment","google","reality","virtual"]},"styles":["solid"],"unicode":"f729","label":"Cardboard VR","free":["solid"],"class":"vr-cardboard"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f41f","label":"Vue.js","free":["brands"],"class":"vuejs"},{"search":{"terms":["exercise","health","pedometer","person","steps"]},"styles":["solid"],"unicode":"f554","label":"Walking","free":["solid"],"class":"walking"},{"search":{"terms":["billfold","cash","currency","money"]},"styles":["solid"],"unicode":"f555","label":"Wallet","free":["solid"],"class":"wallet"},{"search":{"terms":["building","capacity","garage","inventory","storage"]},"styles":["solid"],"unicode":"f494","label":"Warehouse","free":["solid"],"class":"warehouse"},{"search":{"terms":["lake","liquid","ocean","sea","swim","wet"]},"styles":["solid"],"unicode":"f773","label":"Water","free":["solid"],"class":"water"},{"search":{"terms":["frequency","pulse","signal"]},"styles":["solid"],"unicode":"f83e","label":"Square Wave","free":["solid"],"class":"wave-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f83f","label":"Waze","free":["brands"],"class":"waze"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5cc","label":"Weebly","free":["brands"],"class":"weebly"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f18a","label":"Weibo","free":["brands"],"class":"weibo"},{"search":{"terms":["health","measurement","scale","weight"]},"styles":["solid"],"unicode":"f496","label":"Weight","free":["solid"],"class":"weight"},{"search":{"terms":["anvil","heavy","measurement"]},"styles":["solid"],"unicode":"f5cd","label":"Hanging Weight","free":["solid"],"class":"weight-hanging"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1d7","label":"Weixin (WeChat)","free":["brands"],"class":"weixin"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f232","label":"What's App","free":["brands"],"class":"whatsapp"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f40c","label":"What's App Square","free":["brands"],"class":"whatsapp-square"},{"search":{"terms":["accessible","handicap","person"]},"styles":["solid"],"unicode":"f193","label":"Wheelchair","free":["solid"],"class":"wheelchair"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f40d","label":"WHMCS","free":["brands"],"class":"whmcs"},{"search":{"terms":["connection","hotspot","internet","network","wireless"]},"styles":["solid"],"unicode":"f1eb","label":"WiFi","free":["solid"],"class":"wifi"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f266","label":"Wikipedia W","free":["brands"],"class":"wikipedia-w"},{"search":{"terms":["air","blow","breeze","fall","seasonal","weather"]},"styles":["solid"],"unicode":"f72e","label":"Wind","free":["solid"],"class":"wind"},{"search":{"terms":["browser","cancel","computer","development"]},"styles":["solid","regular"],"unicode":"f410","label":"Window Close","free":["solid","regular"],"class":"window-close"},{"search":{"terms":["browser","computer","development","expand"]},"styles":["solid","regular"],"unicode":"f2d0","label":"Window Maximize","free":["solid","regular"],"class":"window-maximize"},{"search":{"terms":["browser","collapse","computer","development"]},"styles":["solid","regular"],"unicode":"f2d1","label":"Window Minimize","free":["solid","regular"],"class":"window-minimize"},{"search":{"terms":["browser","computer","development"]},"styles":["solid","regular"],"unicode":"f2d2","label":"Window Restore","free":["solid","regular"],"class":"window-restore"},{"search":{"terms":["microsoft","operating system","os"]},"styles":["brands"],"unicode":"f17a","label":"Windows","free":["brands"],"class":"windows"},{"search":{"terms":["alcohol","beverage","cabernet","drink","glass","grapes","merlot","sauvignon"]},"styles":["solid"],"unicode":"f72f","label":"Wine Bottle","free":["solid"],"class":"wine-bottle"},{"search":{"terms":["alcohol","beverage","cabernet","drink","grapes","merlot","sauvignon"]},"styles":["solid"],"unicode":"f4e3","label":"Wine Glass","free":["solid"],"class":"wine-glass"},{"search":{"terms":["alcohol","beverage","cabernet","drink","grapes","merlot","sauvignon"]},"styles":["solid"],"unicode":"f5ce","label":"Alternate Wine Glas","free":["solid"],"class":"wine-glass-alt"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f5cf","label":"Wix","free":["brands"],"class":"wix"},{"search":{"terms":["Dungeons & Dragons","d&d","dnd","fantasy","game","gaming","tabletop"]},"styles":["brands"],"unicode":"f730","label":"Wizards of the Coast","free":["brands"],"class":"wizards-of-the-coast"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f514","label":"Wolf Pack Battalion","free":["brands"],"class":"wolf-pack-battalion"},{"search":{"terms":["currency","krw","money"]},"styles":["solid"],"unicode":"f159","label":"Won Sign","free":["solid"],"class":"won-sign"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f19a","label":"WordPress Logo","free":["brands"],"class":"wordpress"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f411","label":"Wordpress Simple","free":["brands"],"class":"wordpress-simple"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f297","label":"WPBeginner","free":["brands"],"class":"wpbeginner"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2de","label":"WPExplorer","free":["brands"],"class":"wpexplorer"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f298","label":"WPForms","free":["brands"],"class":"wpforms"},{"search":{"terms":["rendact"]},"styles":["brands"],"unicode":"f3e4","label":"wpressr","free":["brands"],"class":"wpressr"},{"search":{"terms":["construction","fix","mechanic","plumbing","settings","spanner","tool","update"]},"styles":["solid"],"unicode":"f0ad","label":"Wrench","free":["solid"],"class":"wrench"},{"search":{"terms":["health","medical","radiological images","radiology","skeleton"]},"styles":["solid"],"unicode":"f497","label":"X-Ray","free":["solid"],"class":"x-ray"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f412","label":"Xbox","free":["brands"],"class":"xbox"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f168","label":"Xing","free":["brands"],"class":"xing"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f169","label":"Xing Square","free":["brands"],"class":"xing-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f23b","label":"Y Combinator","free":["brands"],"class":"y-combinator"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f19e","label":"Yahoo Logo","free":["brands"],"class":"yahoo"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f840","label":"Yammer","free":["brands"],"class":"yammer"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f413","label":"Yandex","free":["brands"],"class":"yandex"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f414","label":"Yandex International","free":["brands"],"class":"yandex-international"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f7e3","label":"Yarn","free":["brands"],"class":"yarn"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f1e9","label":"Yelp","free":["brands"],"class":"yelp"},{"search":{"terms":["currency","jpy","money"]},"styles":["solid"],"unicode":"f157","label":"Yen Sign","free":["solid"],"class":"yen-sign"},{"search":{"terms":["daoism","opposites","taoism"]},"styles":["solid"],"unicode":"f6ad","label":"Yin Yang","free":["solid"],"class":"yin-yang"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f2b1","label":"Yoast","free":["brands"],"class":"yoast"},{"search":{"terms":["film","video","youtube-play","youtube-square"]},"styles":["brands"],"unicode":"f167","label":"YouTube","free":["brands"],"class":"youtube"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f431","label":"YouTube Square","free":["brands"],"class":"youtube-square"},{"search":{"terms":[]},"styles":["brands"],"unicode":"f63f","label":"Zhihu","free":["brands"],"class":"zhihu"}];

/***/ }),

/***/ "2621":
/***/ (function(module, exports) {

exports.f = Object.getOwnPropertySymbols;


/***/ }),

/***/ "294c":
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (e) {
    return true;
  }
};


/***/ }),

/***/ "2aba":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("7726");
var hide = __webpack_require__("32e9");
var has = __webpack_require__("69a8");
var SRC = __webpack_require__("ca5a")('src');
var $toString = __webpack_require__("fa5b");
var TO_STRING = 'toString';
var TPL = ('' + $toString).split(TO_STRING);

__webpack_require__("8378").inspectSource = function (it) {
  return $toString.call(it);
};

(module.exports = function (O, key, val, safe) {
  var isFunction = typeof val == 'function';
  if (isFunction) has(val, 'name') || hide(val, 'name', key);
  if (O[key] === val) return;
  if (isFunction) has(val, SRC) || hide(val, SRC, O[key] ? '' + O[key] : TPL.join(String(key)));
  if (O === global) {
    O[key] = val;
  } else if (!safe) {
    delete O[key];
    hide(O, key, val);
  } else if (O[key]) {
    O[key] = val;
  } else {
    hide(O, key, val);
  }
// add fake Function#toString for correct work wrapped methods / constructors with methods like LoDash isNative
})(Function.prototype, TO_STRING, function toString() {
  return typeof this == 'function' && this[SRC] || $toString.call(this);
});


/***/ }),

/***/ "2aeb":
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
var anObject = __webpack_require__("cb7c");
var dPs = __webpack_require__("1495");
var enumBugKeys = __webpack_require__("e11e");
var IE_PROTO = __webpack_require__("613b")('IE_PROTO');
var Empty = function () { /* empty */ };
var PROTOTYPE = 'prototype';

// Create object with fake `null` prototype: use iframe Object with cleared prototype
var createDict = function () {
  // Thrash, waste and sodomy: IE GC bug
  var iframe = __webpack_require__("230e")('iframe');
  var i = enumBugKeys.length;
  var lt = '<';
  var gt = '>';
  var iframeDocument;
  iframe.style.display = 'none';
  __webpack_require__("fab2").appendChild(iframe);
  iframe.src = 'javascript:'; // eslint-disable-line no-script-url
  // createDict = iframe.contentWindow.Object;
  // html.removeChild(iframe);
  iframeDocument = iframe.contentWindow.document;
  iframeDocument.open();
  iframeDocument.write(lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt);
  iframeDocument.close();
  createDict = iframeDocument.F;
  while (i--) delete createDict[PROTOTYPE][enumBugKeys[i]];
  return createDict();
};

module.exports = Object.create || function create(O, Properties) {
  var result;
  if (O !== null) {
    Empty[PROTOTYPE] = anObject(O);
    result = new Empty();
    Empty[PROTOTYPE] = null;
    // add "__proto__" for Object.getPrototypeOf polyfill
    result[IE_PROTO] = O;
  } else result = createDict();
  return Properties === undefined ? result : dPs(result, Properties);
};


/***/ }),

/***/ "2b4c":
/***/ (function(module, exports, __webpack_require__) {

var store = __webpack_require__("5537")('wks');
var uid = __webpack_require__("ca5a");
var Symbol = __webpack_require__("7726").Symbol;
var USE_SYMBOL = typeof Symbol == 'function';

var $exports = module.exports = function (name) {
  return store[name] || (store[name] =
    USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
};

$exports.store = store;


/***/ }),

/***/ "2d00":
/***/ (function(module, exports) {

module.exports = false;


/***/ }),

/***/ "2d95":
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),

/***/ "2fdb":
/***/ (function(module, exports, __webpack_require__) {

"use strict";
// 21.1.3.7 String.prototype.includes(searchString, position = 0)

var $export = __webpack_require__("5ca1");
var context = __webpack_require__("d2c8");
var INCLUDES = 'includes';

$export($export.P + $export.F * __webpack_require__("5147")(INCLUDES), 'String', {
  includes: function includes(searchString /* , position = 0 */) {
    return !!~context(this, searchString, INCLUDES)
      .indexOf(searchString, arguments.length > 1 ? arguments[1] : undefined);
  }
});


/***/ }),

/***/ "32e9":
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__("86cc");
var createDesc = __webpack_require__("4630");
module.exports = __webpack_require__("9e1e") ? function (object, key, value) {
  return dP.f(object, key, createDesc(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),

/***/ "35e8":
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__("d9f6");
var createDesc = __webpack_require__("aebd");
module.exports = __webpack_require__("8e60") ? function (object, key, value) {
  return dP.f(object, key, createDesc(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),

/***/ "385f":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("2350")(false);
// imports


// module
exports.push([module.i, ".vfa-container{display:-webkit-box;display:-ms-flexbox;display:flex;width:100%;height:100%;top:0;left:0;position:fixed;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;background:rgba(0,0,0,.5);color:#495057;z-index:999999999}.vfa-container,.vfa-container *{-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.vfa-container *{margin:0;-webkit-box-sizing:border-box;box-sizing:border-box;padding:0;outline:none;border:none}.vfa-content{background:#f8f9fa;position:relative;overflow:hidden}.vfa-header{height:50px;width:100%;-webkit-box-sizing:border-box;box-sizing:border-box;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.vfa-icons-container{height:calc(100% - 50px);width:100%;padding-bottom:50px}.vfa-icons{height:100%;-ms-flex-wrap:wrap;flex-wrap:wrap;overflow:auto;-webkit-box-pack:space-evenly;-ms-flex-pack:space-evenly;justify-content:space-evenly}.vfa-icons,.vfa-pagination{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.vfa-pagination{position:absolute;width:100%;height:50px;left:0;bottom:0;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;background:#495057;padding:0 10px;-webkit-box-sizing:border-box;box-sizing:border-box;color:#fafafa}.vfa-pagination-item{font-size:40px;margin:0 20px;cursor:pointer}.vfa-icon{width:100px;height:65px;margin:5px;border-radius:5px;text-align:center;cursor:pointer}.vfa-icon .vfa-icon-preview{font-size:40px;padding:3px;display:block;color:#495057}.vfa-icon.selected,.vfa-icon:hover{background:#009688}.vfa-icon.selected .vfa-icon-preview,.vfa-icon:hover .vfa-icon-preview{color:#fafafa}.vfa-icon.selected .vfa-icon-info,.vfa-icon:hover .vfa-icon-info{background:#fff}.vfa-icon.selected .vfa-icon-info .class,.vfa-icon:hover .vfa-icon-info .class{color:#414141}.vfa-search{text-align:center;-webkit-box-flex:7;-ms-flex:7;flex:7}.vfa-search,.vfa-search input{-webkit-transition:all .3s linear;transition:all .3s linear}.vfa-search input{height:40px;min-width:260px;width:98%;max-width:400px;padding:5px;color:#495057;border-bottom:1px solid #495057}.vfa-search input,.vfa-search input:focus{background:transparent}.vfa-icon-info{height:25px}.vfa-icon-info .class{font-size:12px;line-height:25px;color:#adb5bd;display:block;padding:0 5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}", ""]);

// exports


/***/ }),

/***/ "38fd":
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
var has = __webpack_require__("69a8");
var toObject = __webpack_require__("4bf8");
var IE_PROTO = __webpack_require__("613b")('IE_PROTO');
var ObjectProto = Object.prototype;

module.exports = Object.getPrototypeOf || function (O) {
  O = toObject(O);
  if (has(O, IE_PROTO)) return O[IE_PROTO];
  if (typeof O.constructor == 'function' && O instanceof O.constructor) {
    return O.constructor.prototype;
  } return O instanceof Object ? ObjectProto : null;
};


/***/ }),

/***/ "41a0":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var create = __webpack_require__("2aeb");
var descriptor = __webpack_require__("4630");
var setToStringTag = __webpack_require__("7f20");
var IteratorPrototype = {};

// 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
__webpack_require__("32e9")(IteratorPrototype, __webpack_require__("2b4c")('iterator'), function () { return this; });

module.exports = function (Constructor, NAME, next) {
  Constructor.prototype = create(IteratorPrototype, { next: descriptor(1, next) });
  setToStringTag(Constructor, NAME + ' Iterator');
};


/***/ }),

/***/ "454f":
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("46a7");
var $Object = __webpack_require__("584a").Object;
module.exports = function defineProperty(it, key, desc) {
  return $Object.defineProperty(it, key, desc);
};


/***/ }),

/***/ "456d":
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.14 Object.keys(O)
var toObject = __webpack_require__("4bf8");
var $keys = __webpack_require__("0d58");

__webpack_require__("5eda")('keys', function () {
  return function keys(it) {
    return $keys(toObject(it));
  };
});


/***/ }),

/***/ "4588":
/***/ (function(module, exports) {

// 7.1.4 ToInteger
var ceil = Math.ceil;
var floor = Math.floor;
module.exports = function (it) {
  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
};


/***/ }),

/***/ "4630":
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),

/***/ "46a7":
/***/ (function(module, exports, __webpack_require__) {

var $export = __webpack_require__("63b6");
// 19.1.2.4 / 15.2.3.6 Object.defineProperty(O, P, Attributes)
$export($export.S + $export.F * !__webpack_require__("8e60"), 'Object', { defineProperty: __webpack_require__("d9f6").f });


/***/ }),

/***/ "499e":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

// CONCATENATED MODULE: ./node_modules/vue-style-loader/lib/listToStyles.js
/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}

// CONCATENATED MODULE: ./node_modules/vue-style-loader/lib/addStylesClient.js
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return addStylesClient; });
/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/



var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

function addStylesClient (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ "4bf8":
/***/ (function(module, exports, __webpack_require__) {

// 7.1.13 ToObject(argument)
var defined = __webpack_require__("be13");
module.exports = function (it) {
  return Object(defined(it));
};


/***/ }),

/***/ "5147":
/***/ (function(module, exports, __webpack_require__) {

var MATCH = __webpack_require__("2b4c")('match');
module.exports = function (KEY) {
  var re = /./;
  try {
    '/./'[KEY](re);
  } catch (e) {
    try {
      re[MATCH] = false;
      return !'/./'[KEY](re);
    } catch (f) { /* empty */ }
  } return true;
};


/***/ }),

/***/ "52a7":
/***/ (function(module, exports) {

exports.f = {}.propertyIsEnumerable;


/***/ }),

/***/ "5537":
/***/ (function(module, exports, __webpack_require__) {

var core = __webpack_require__("8378");
var global = __webpack_require__("7726");
var SHARED = '__core-js_shared__';
var store = global[SHARED] || (global[SHARED] = {});

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: core.version,
  mode: __webpack_require__("2d00") ? 'pure' : 'global',
  copyright: '© 2019 Denis Pushkarev (zloirock.ru)'
});


/***/ }),

/***/ "584a":
/***/ (function(module, exports) {

var core = module.exports = { version: '2.6.9' };
if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),

/***/ "5ca1":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("7726");
var core = __webpack_require__("8378");
var hide = __webpack_require__("32e9");
var redefine = __webpack_require__("2aba");
var ctx = __webpack_require__("9b43");
var PROTOTYPE = 'prototype';

var $export = function (type, name, source) {
  var IS_FORCED = type & $export.F;
  var IS_GLOBAL = type & $export.G;
  var IS_STATIC = type & $export.S;
  var IS_PROTO = type & $export.P;
  var IS_BIND = type & $export.B;
  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] || (global[name] = {}) : (global[name] || {})[PROTOTYPE];
  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
  var expProto = exports[PROTOTYPE] || (exports[PROTOTYPE] = {});
  var key, own, out, exp;
  if (IS_GLOBAL) source = name;
  for (key in source) {
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    // export native or passed
    out = (own ? target : source)[key];
    // bind timers to global for call from export context
    exp = IS_BIND && own ? ctx(out, global) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // extend global
    if (target) redefine(target, key, out, type & $export.U);
    // export
    if (exports[key] != out) hide(exports, key, exp);
    if (IS_PROTO && expProto[key] != out) expProto[key] = out;
  }
};
global.core = core;
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library`
module.exports = $export;


/***/ }),

/***/ "5dbc":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("d3f4");
var setPrototypeOf = __webpack_require__("8b97").set;
module.exports = function (that, target, C) {
  var S = target.constructor;
  var P;
  if (S !== C && typeof S == 'function' && (P = S.prototype) !== C.prototype && isObject(P) && setPrototypeOf) {
    setPrototypeOf(that, P);
  } return that;
};


/***/ }),

/***/ "5eda":
/***/ (function(module, exports, __webpack_require__) {

// most Object methods by ES6 should accept primitives
var $export = __webpack_require__("5ca1");
var core = __webpack_require__("8378");
var fails = __webpack_require__("79e5");
module.exports = function (KEY, exec) {
  var fn = (core.Object || {})[KEY] || Object[KEY];
  var exp = {};
  exp[KEY] = exec(fn);
  $export($export.S + $export.F * fails(function () { fn(1); }), 'Object', exp);
};


/***/ }),

/***/ "613b":
/***/ (function(module, exports, __webpack_require__) {

var shared = __webpack_require__("5537")('keys');
var uid = __webpack_require__("ca5a");
module.exports = function (key) {
  return shared[key] || (shared[key] = uid(key));
};


/***/ }),

/***/ "626a":
/***/ (function(module, exports, __webpack_require__) {

// fallback for non-array-like ES3 and non-enumerable old V8 strings
var cof = __webpack_require__("2d95");
// eslint-disable-next-line no-prototype-builtins
module.exports = Object('z').propertyIsEnumerable(0) ? Object : function (it) {
  return cof(it) == 'String' ? it.split('') : Object(it);
};


/***/ }),

/***/ "63b6":
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__("e53d");
var core = __webpack_require__("584a");
var ctx = __webpack_require__("d864");
var hide = __webpack_require__("35e8");
var has = __webpack_require__("07e3");
var PROTOTYPE = 'prototype';

var $export = function (type, name, source) {
  var IS_FORCED = type & $export.F;
  var IS_GLOBAL = type & $export.G;
  var IS_STATIC = type & $export.S;
  var IS_PROTO = type & $export.P;
  var IS_BIND = type & $export.B;
  var IS_WRAP = type & $export.W;
  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
  var expProto = exports[PROTOTYPE];
  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE];
  var key, own, out;
  if (IS_GLOBAL) source = name;
  for (key in source) {
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    if (own && has(exports, key)) continue;
    // export native or passed
    out = own ? target[key] : source[key];
    // prevent global pollution for namespaces
    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
    // bind timers to global for call from export context
    : IS_BIND && own ? ctx(out, global)
    // wrap global constructors for prevent change them in library
    : IS_WRAP && target[key] == out ? (function (C) {
      var F = function (a, b, c) {
        if (this instanceof C) {
          switch (arguments.length) {
            case 0: return new C();
            case 1: return new C(a);
            case 2: return new C(a, b);
          } return new C(a, b, c);
        } return C.apply(this, arguments);
      };
      F[PROTOTYPE] = C[PROTOTYPE];
      return F;
    // make static versions for prototype methods
    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
    if (IS_PROTO) {
      (exports.virtual || (exports.virtual = {}))[key] = out;
      // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
      if (type & $export.R && expProto && !expProto[key]) hide(expProto, key, out);
    }
  }
};
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library`
module.exports = $export;


/***/ }),

/***/ "6762":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// https://github.com/tc39/Array.prototype.includes
var $export = __webpack_require__("5ca1");
var $includes = __webpack_require__("c366")(true);

$export($export.P, 'Array', {
  includes: function includes(el /* , fromIndex = 0 */) {
    return $includes(this, el, arguments.length > 1 ? arguments[1] : undefined);
  }
});

__webpack_require__("9c6c")('includes');


/***/ }),

/***/ "6821":
/***/ (function(module, exports, __webpack_require__) {

// to indexed object, toObject with fallback for non-array-like ES3 strings
var IObject = __webpack_require__("626a");
var defined = __webpack_require__("be13");
module.exports = function (it) {
  return IObject(defined(it));
};


/***/ }),

/***/ "69a8":
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;
module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),

/***/ "6a99":
/***/ (function(module, exports, __webpack_require__) {

// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = __webpack_require__("d3f4");
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (it, S) {
  if (!isObject(it)) return it;
  var fn, val;
  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),

/***/ "7726":
/***/ (function(module, exports) {

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),

/***/ "77f1":
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__("4588");
var max = Math.max;
var min = Math.min;
module.exports = function (index, length) {
  index = toInteger(index);
  return index < 0 ? max(index + length, 0) : min(index, length);
};


/***/ }),

/***/ "794b":
/***/ (function(module, exports, __webpack_require__) {

module.exports = !__webpack_require__("8e60") && !__webpack_require__("294c")(function () {
  return Object.defineProperty(__webpack_require__("1ec9")('div'), 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),

/***/ "79aa":
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
  return it;
};


/***/ }),

/***/ "79e5":
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (e) {
    return true;
  }
};


/***/ }),

/***/ "7f20":
/***/ (function(module, exports, __webpack_require__) {

var def = __webpack_require__("86cc").f;
var has = __webpack_require__("69a8");
var TAG = __webpack_require__("2b4c")('toStringTag');

module.exports = function (it, tag, stat) {
  if (it && !has(it = stat ? it : it.prototype, TAG)) def(it, TAG, { configurable: true, value: tag });
};


/***/ }),

/***/ "8378":
/***/ (function(module, exports) {

var core = module.exports = { version: '2.6.9' };
if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),

/***/ "84f2":
/***/ (function(module, exports) {

module.exports = {};


/***/ }),

/***/ "85f2":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("454f");

/***/ }),

/***/ "86cc":
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__("cb7c");
var IE8_DOM_DEFINE = __webpack_require__("c69a");
var toPrimitive = __webpack_require__("6a99");
var dP = Object.defineProperty;

exports.f = __webpack_require__("9e1e") ? Object.defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return dP(O, P, Attributes);
  } catch (e) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),

/***/ "8b97":
/***/ (function(module, exports, __webpack_require__) {

// Works with __proto__ only. Old v8 can't work with null proto objects.
/* eslint-disable no-proto */
var isObject = __webpack_require__("d3f4");
var anObject = __webpack_require__("cb7c");
var check = function (O, proto) {
  anObject(O);
  if (!isObject(proto) && proto !== null) throw TypeError(proto + ": can't set as prototype!");
};
module.exports = {
  set: Object.setPrototypeOf || ('__proto__' in {} ? // eslint-disable-line
    function (test, buggy, set) {
      try {
        set = __webpack_require__("9b43")(Function.call, __webpack_require__("11e9").f(Object.prototype, '__proto__').set, 2);
        set(test, []);
        buggy = !(test instanceof Array);
      } catch (e) { buggy = true; }
      return function setPrototypeOf(O, proto) {
        check(O, proto);
        if (buggy) O.__proto__ = proto;
        else set(O, proto);
        return O;
      };
    }({}, false) : undefined),
  check: check
};


/***/ }),

/***/ "8e60":
/***/ (function(module, exports, __webpack_require__) {

// Thank's IE8 for his funny defineProperty
module.exports = !__webpack_require__("294c")(function () {
  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),

/***/ "8e6e":
/***/ (function(module, exports, __webpack_require__) {

// https://github.com/tc39/proposal-object-getownpropertydescriptors
var $export = __webpack_require__("5ca1");
var ownKeys = __webpack_require__("990b");
var toIObject = __webpack_require__("6821");
var gOPD = __webpack_require__("11e9");
var createProperty = __webpack_require__("f1ae");

$export($export.S, 'Object', {
  getOwnPropertyDescriptors: function getOwnPropertyDescriptors(object) {
    var O = toIObject(object);
    var getDesc = gOPD.f;
    var keys = ownKeys(O);
    var result = {};
    var i = 0;
    var key, desc;
    while (keys.length > i) {
      desc = getDesc(O, key = keys[i++]);
      if (desc !== undefined) createProperty(result, key, desc);
    }
    return result;
  }
});


/***/ }),

/***/ "9093":
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.7 / 15.2.3.4 Object.getOwnPropertyNames(O)
var $keys = __webpack_require__("ce10");
var hiddenKeys = __webpack_require__("e11e").concat('length', 'prototype');

exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O) {
  return $keys(O, hiddenKeys);
};


/***/ }),

/***/ "990b":
/***/ (function(module, exports, __webpack_require__) {

// all object keys, includes non-enumerable and symbols
var gOPN = __webpack_require__("9093");
var gOPS = __webpack_require__("2621");
var anObject = __webpack_require__("cb7c");
var Reflect = __webpack_require__("7726").Reflect;
module.exports = Reflect && Reflect.ownKeys || function ownKeys(it) {
  var keys = gOPN.f(anObject(it));
  var getSymbols = gOPS.f;
  return getSymbols ? keys.concat(getSymbols(it)) : keys;
};


/***/ }),

/***/ "9b43":
/***/ (function(module, exports, __webpack_require__) {

// optional / simple context binding
var aFunction = __webpack_require__("d8e8");
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),

/***/ "9c6c":
/***/ (function(module, exports, __webpack_require__) {

// 22.1.3.31 Array.prototype[@@unscopables]
var UNSCOPABLES = __webpack_require__("2b4c")('unscopables');
var ArrayProto = Array.prototype;
if (ArrayProto[UNSCOPABLES] == undefined) __webpack_require__("32e9")(ArrayProto, UNSCOPABLES, {});
module.exports = function (key) {
  ArrayProto[UNSCOPABLES][key] = true;
};


/***/ }),

/***/ "9def":
/***/ (function(module, exports, __webpack_require__) {

// 7.1.15 ToLength
var toInteger = __webpack_require__("4588");
var min = Math.min;
module.exports = function (it) {
  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
};


/***/ }),

/***/ "9e1e":
/***/ (function(module, exports, __webpack_require__) {

// Thank's IE8 for his funny defineProperty
module.exports = !__webpack_require__("79e5")(function () {
  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),

/***/ "aa77":
/***/ (function(module, exports, __webpack_require__) {

var $export = __webpack_require__("5ca1");
var defined = __webpack_require__("be13");
var fails = __webpack_require__("79e5");
var spaces = __webpack_require__("fdef");
var space = '[' + spaces + ']';
var non = '\u200b\u0085';
var ltrim = RegExp('^' + space + space + '*');
var rtrim = RegExp(space + space + '*$');

var exporter = function (KEY, exec, ALIAS) {
  var exp = {};
  var FORCE = fails(function () {
    return !!spaces[KEY]() || non[KEY]() != non;
  });
  var fn = exp[KEY] = FORCE ? exec(trim) : spaces[KEY];
  if (ALIAS) exp[ALIAS] = fn;
  $export($export.P + $export.F * FORCE, 'String', exp);
};

// 1 -> String#trimLeft
// 2 -> String#trimRight
// 3 -> String#trim
var trim = exporter.trim = function (string, TYPE) {
  string = String(defined(string));
  if (TYPE & 1) string = string.replace(ltrim, '');
  if (TYPE & 2) string = string.replace(rtrim, '');
  return string;
};

module.exports = exporter;


/***/ }),

/***/ "aae3":
/***/ (function(module, exports, __webpack_require__) {

// 7.2.8 IsRegExp(argument)
var isObject = __webpack_require__("d3f4");
var cof = __webpack_require__("2d95");
var MATCH = __webpack_require__("2b4c")('match');
module.exports = function (it) {
  var isRegExp;
  return isObject(it) && ((isRegExp = it[MATCH]) !== undefined ? !!isRegExp : cof(it) == 'RegExp');
};


/***/ }),

/***/ "ac6a":
/***/ (function(module, exports, __webpack_require__) {

var $iterators = __webpack_require__("cadf");
var getKeys = __webpack_require__("0d58");
var redefine = __webpack_require__("2aba");
var global = __webpack_require__("7726");
var hide = __webpack_require__("32e9");
var Iterators = __webpack_require__("84f2");
var wks = __webpack_require__("2b4c");
var ITERATOR = wks('iterator');
var TO_STRING_TAG = wks('toStringTag');
var ArrayValues = Iterators.Array;

var DOMIterables = {
  CSSRuleList: true, // TODO: Not spec compliant, should be false.
  CSSStyleDeclaration: false,
  CSSValueList: false,
  ClientRectList: false,
  DOMRectList: false,
  DOMStringList: false,
  DOMTokenList: true,
  DataTransferItemList: false,
  FileList: false,
  HTMLAllCollection: false,
  HTMLCollection: false,
  HTMLFormElement: false,
  HTMLSelectElement: false,
  MediaList: true, // TODO: Not spec compliant, should be false.
  MimeTypeArray: false,
  NamedNodeMap: false,
  NodeList: true,
  PaintRequestList: false,
  Plugin: false,
  PluginArray: false,
  SVGLengthList: false,
  SVGNumberList: false,
  SVGPathSegList: false,
  SVGPointList: false,
  SVGStringList: false,
  SVGTransformList: false,
  SourceBufferList: false,
  StyleSheetList: true, // TODO: Not spec compliant, should be false.
  TextTrackCueList: false,
  TextTrackList: false,
  TouchList: false
};

for (var collections = getKeys(DOMIterables), i = 0; i < collections.length; i++) {
  var NAME = collections[i];
  var explicit = DOMIterables[NAME];
  var Collection = global[NAME];
  var proto = Collection && Collection.prototype;
  var key;
  if (proto) {
    if (!proto[ITERATOR]) hide(proto, ITERATOR, ArrayValues);
    if (!proto[TO_STRING_TAG]) hide(proto, TO_STRING_TAG, NAME);
    Iterators[NAME] = ArrayValues;
    if (explicit) for (key in $iterators) if (!proto[key]) redefine(proto, key, $iterators[key], true);
  }
}


/***/ }),

/***/ "aebd":
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),

/***/ "b01a":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var _node_modules_vue_style_loader_index_js_ref_9_oneOf_1_0_node_modules_css_loader_index_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_3_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_4_node_modules_cache_loader_dist_cjs_js_ref_0_0_node_modules_vue_loader_lib_index_js_vue_loader_options_vfa_picker_component_vue_vue_type_style_index_0_id_34a597f6_lang_sass_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("f96b");
/* harmony import */ var _node_modules_vue_style_loader_index_js_ref_9_oneOf_1_0_node_modules_css_loader_index_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_3_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_4_node_modules_cache_loader_dist_cjs_js_ref_0_0_node_modules_vue_loader_lib_index_js_vue_loader_options_vfa_picker_component_vue_vue_type_style_index_0_id_34a597f6_lang_sass_scoped_true___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_vue_style_loader_index_js_ref_9_oneOf_1_0_node_modules_css_loader_index_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_3_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_4_node_modules_cache_loader_dist_cjs_js_ref_0_0_node_modules_vue_loader_lib_index_js_vue_loader_options_vfa_picker_component_vue_vue_type_style_index_0_id_34a597f6_lang_sass_scoped_true___WEBPACK_IMPORTED_MODULE_0__);
/* unused harmony reexport * */
 /* unused harmony default export */ var _unused_webpack_default_export = (_node_modules_vue_style_loader_index_js_ref_9_oneOf_1_0_node_modules_css_loader_index_js_ref_9_oneOf_1_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_2_node_modules_postcss_loader_src_index_js_ref_9_oneOf_1_3_node_modules_sass_loader_dist_cjs_js_ref_9_oneOf_1_4_node_modules_cache_loader_dist_cjs_js_ref_0_0_node_modules_vue_loader_lib_index_js_vue_loader_options_vfa_picker_component_vue_vue_type_style_index_0_id_34a597f6_lang_sass_scoped_true___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "be13":
/***/ (function(module, exports) {

// 7.2.1 RequireObjectCoercible(argument)
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on  " + it);
  return it;
};


/***/ }),

/***/ "be5b":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("385f");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var add = __webpack_require__("499e").default
var update = add("3dda2ae3", content, true, {"sourceMap":false,"shadowMode":false});

/***/ }),

/***/ "c366":
/***/ (function(module, exports, __webpack_require__) {

// false -> Array#indexOf
// true  -> Array#includes
var toIObject = __webpack_require__("6821");
var toLength = __webpack_require__("9def");
var toAbsoluteIndex = __webpack_require__("77f1");
module.exports = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIObject($this);
    var length = toLength(O.length);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) if (IS_INCLUDES || index in O) {
      if (O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};


/***/ }),

/***/ "c5f6":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var global = __webpack_require__("7726");
var has = __webpack_require__("69a8");
var cof = __webpack_require__("2d95");
var inheritIfRequired = __webpack_require__("5dbc");
var toPrimitive = __webpack_require__("6a99");
var fails = __webpack_require__("79e5");
var gOPN = __webpack_require__("9093").f;
var gOPD = __webpack_require__("11e9").f;
var dP = __webpack_require__("86cc").f;
var $trim = __webpack_require__("aa77").trim;
var NUMBER = 'Number';
var $Number = global[NUMBER];
var Base = $Number;
var proto = $Number.prototype;
// Opera ~12 has broken Object#toString
var BROKEN_COF = cof(__webpack_require__("2aeb")(proto)) == NUMBER;
var TRIM = 'trim' in String.prototype;

// 7.1.3 ToNumber(argument)
var toNumber = function (argument) {
  var it = toPrimitive(argument, false);
  if (typeof it == 'string' && it.length > 2) {
    it = TRIM ? it.trim() : $trim(it, 3);
    var first = it.charCodeAt(0);
    var third, radix, maxCode;
    if (first === 43 || first === 45) {
      third = it.charCodeAt(2);
      if (third === 88 || third === 120) return NaN; // Number('+0x1') should be NaN, old V8 fix
    } else if (first === 48) {
      switch (it.charCodeAt(1)) {
        case 66: case 98: radix = 2; maxCode = 49; break; // fast equal /^0b[01]+$/i
        case 79: case 111: radix = 8; maxCode = 55; break; // fast equal /^0o[0-7]+$/i
        default: return +it;
      }
      for (var digits = it.slice(2), i = 0, l = digits.length, code; i < l; i++) {
        code = digits.charCodeAt(i);
        // parseInt parses a string to a first unavailable symbol
        // but ToNumber should return NaN if a string contains unavailable symbols
        if (code < 48 || code > maxCode) return NaN;
      } return parseInt(digits, radix);
    }
  } return +it;
};

if (!$Number(' 0o1') || !$Number('0b1') || $Number('+0x1')) {
  $Number = function Number(value) {
    var it = arguments.length < 1 ? 0 : value;
    var that = this;
    return that instanceof $Number
      // check on 1..constructor(foo) case
      && (BROKEN_COF ? fails(function () { proto.valueOf.call(that); }) : cof(that) != NUMBER)
        ? inheritIfRequired(new Base(toNumber(it)), that, $Number) : toNumber(it);
  };
  for (var keys = __webpack_require__("9e1e") ? gOPN(Base) : (
    // ES3:
    'MAX_VALUE,MIN_VALUE,NaN,NEGATIVE_INFINITY,POSITIVE_INFINITY,' +
    // ES6 (in case, if modules with ES6 Number statics required before):
    'EPSILON,isFinite,isInteger,isNaN,isSafeInteger,MAX_SAFE_INTEGER,' +
    'MIN_SAFE_INTEGER,parseFloat,parseInt,isInteger'
  ).split(','), j = 0, key; keys.length > j; j++) {
    if (has(Base, key = keys[j]) && !has($Number, key)) {
      dP($Number, key, gOPD(Base, key));
    }
  }
  $Number.prototype = proto;
  proto.constructor = $Number;
  __webpack_require__("2aba")(global, NUMBER, $Number);
}


/***/ }),

/***/ "c69a":
/***/ (function(module, exports, __webpack_require__) {

module.exports = !__webpack_require__("9e1e") && !__webpack_require__("79e5")(function () {
  return Object.defineProperty(__webpack_require__("230e")('div'), 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),

/***/ "ca5a":
/***/ (function(module, exports) {

var id = 0;
var px = Math.random();
module.exports = function (key) {
  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
};


/***/ }),

/***/ "cadf":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var addToUnscopables = __webpack_require__("9c6c");
var step = __webpack_require__("d53b");
var Iterators = __webpack_require__("84f2");
var toIObject = __webpack_require__("6821");

// 22.1.3.4 Array.prototype.entries()
// 22.1.3.13 Array.prototype.keys()
// 22.1.3.29 Array.prototype.values()
// 22.1.3.30 Array.prototype[@@iterator]()
module.exports = __webpack_require__("01f9")(Array, 'Array', function (iterated, kind) {
  this._t = toIObject(iterated); // target
  this._i = 0;                   // next index
  this._k = kind;                // kind
// 22.1.5.2.1 %ArrayIteratorPrototype%.next()
}, function () {
  var O = this._t;
  var kind = this._k;
  var index = this._i++;
  if (!O || index >= O.length) {
    this._t = undefined;
    return step(1);
  }
  if (kind == 'keys') return step(0, index);
  if (kind == 'values') return step(0, O[index]);
  return step(0, [index, O[index]]);
}, 'values');

// argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
Iterators.Arguments = Iterators.Array;

addToUnscopables('keys');
addToUnscopables('values');
addToUnscopables('entries');


/***/ }),

/***/ "cb7c":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("d3f4");
module.exports = function (it) {
  if (!isObject(it)) throw TypeError(it + ' is not an object!');
  return it;
};


/***/ }),

/***/ "cd69":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("2350")(false);
// imports


// module
exports.push([module.i, ".fade-enter-active[data-v-34a597f6],.fade-leave-active[data-v-34a597f6]{-webkit-transition:opacity .5s;transition:opacity .5s}.fade-enter[data-v-34a597f6],.fade-leave-active[data-v-34a597f6],.fade-leave-to[data-v-34a597f6]{opacity:0}", ""]);

// exports


/***/ }),

/***/ "ce10":
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__("69a8");
var toIObject = __webpack_require__("6821");
var arrayIndexOf = __webpack_require__("c366")(false);
var IE_PROTO = __webpack_require__("613b")('IE_PROTO');

module.exports = function (object, names) {
  var O = toIObject(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) if (key != IE_PROTO) has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (has(O, key = names[i++])) {
    ~arrayIndexOf(result, key) || result.push(key);
  }
  return result;
};


/***/ }),

/***/ "d2c8":
/***/ (function(module, exports, __webpack_require__) {

// helper for String#{startsWith, endsWith, includes}
var isRegExp = __webpack_require__("aae3");
var defined = __webpack_require__("be13");

module.exports = function (that, searchString, NAME) {
  if (isRegExp(searchString)) throw TypeError('String#' + NAME + " doesn't accept regex!");
  return String(defined(that));
};


/***/ }),

/***/ "d3f4":
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),

/***/ "d53b":
/***/ (function(module, exports) {

module.exports = function (done, value) {
  return { value: value, done: !!done };
};


/***/ }),

/***/ "d864":
/***/ (function(module, exports, __webpack_require__) {

// optional / simple context binding
var aFunction = __webpack_require__("79aa");
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),

/***/ "d8e8":
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
  return it;
};


/***/ }),

/***/ "d9f6":
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__("e4ae");
var IE8_DOM_DEFINE = __webpack_require__("794b");
var toPrimitive = __webpack_require__("1bc3");
var dP = Object.defineProperty;

exports.f = __webpack_require__("8e60") ? Object.defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return dP(O, P, Attributes);
  } catch (e) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),

/***/ "e11e":
/***/ (function(module, exports) {

// IE 8- don't enum bug keys
module.exports = (
  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
).split(',');


/***/ }),

/***/ "e4ae":
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__("f772");
module.exports = function (it) {
  if (!isObject(it)) throw TypeError(it + ' is not an object!');
  return it;
};


/***/ }),

/***/ "e53d":
/***/ (function(module, exports) {

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),

/***/ "f1ae":
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $defineProperty = __webpack_require__("86cc");
var createDesc = __webpack_require__("4630");

module.exports = function (object, index, value) {
  if (index in object) $defineProperty.f(object, index, createDesc(0, value));
  else object[index] = value;
};


/***/ }),

/***/ "f6fd":
/***/ (function(module, exports) {

// document.currentScript polyfill by Adam Miller

// MIT license

(function(document){
  var currentScript = "currentScript",
      scripts = document.getElementsByTagName('script'); // Live NodeList collection

  // If browser needs currentScript polyfill, add get currentScript() to the document object
  if (!(currentScript in document)) {
    Object.defineProperty(document, currentScript, {
      get: function(){

        // IE 6-10 supports script readyState
        // IE 10+ support stack trace
        try { throw new Error(); }
        catch (err) {

          // Find the second match for the "at" string to get file src url from stack.
          // Specifically works with the format of stack traces in IE.
          var i, res = ((/.*at [^\(]*\((.*):.+:.+\)$/ig).exec(err.stack) || [false])[1];

          // For all scripts on the page, if src matches or if ready state is interactive, return the script tag
          for(i in scripts){
            if(scripts[i].src == res || scripts[i].readyState == "interactive"){
              return scripts[i];
            }
          }

          // If no match, return null
          return null;
        }
      }
    });
  }
})(document);


/***/ }),

/***/ "f772":
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),

/***/ "f96b":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("cd69");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var add = __webpack_require__("499e").default
var update = add("5082df32", content, true, {"sourceMap":false,"shadowMode":false});

/***/ }),

/***/ "fa5b":
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("5537")('native-function-to-string', Function.toString);


/***/ }),

/***/ "fab2":
/***/ (function(module, exports, __webpack_require__) {

var document = __webpack_require__("7726").document;
module.exports = document && document.documentElement;


/***/ }),

/***/ "fb15":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/setPublicPath.js
// This file is imported into lib/wc client bundles.

if (typeof window !== 'undefined') {
  if (true) {
    __webpack_require__("f6fd")
  }

  var setPublicPath_i
  if ((setPublicPath_i = window.document.currentScript) && (setPublicPath_i = setPublicPath_i.src.match(/(.+\/)[^/]+\.js(\?.*)?$/))) {
    __webpack_require__.p = setPublicPath_i[1] // eslint-disable-line
  }
}

// Indicate to webpack that this file can be concatenated
/* harmony default export */ var setPublicPath = (null);

// EXTERNAL MODULE: ./node_modules/core-js/modules/es7.object.get-own-property-descriptors.js
var es7_object_get_own_property_descriptors = __webpack_require__("8e6e");

// EXTERNAL MODULE: ./node_modules/core-js/modules/web.dom.iterable.js
var web_dom_iterable = __webpack_require__("ac6a");

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.array.iterator.js
var es6_array_iterator = __webpack_require__("cadf");

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.object.keys.js
var es6_object_keys = __webpack_require__("456d");

// CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/classCallCheck.js
function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}
// EXTERNAL MODULE: ./node_modules/@babel/runtime-corejs2/core-js/object/define-property.js
var define_property = __webpack_require__("85f2");
var define_property_default = /*#__PURE__*/__webpack_require__.n(define_property);

// CONCATENATED MODULE: ./node_modules/@babel/runtime-corejs2/helpers/esm/defineProperty.js

function _defineProperty(obj, key, value) {
  if (key in obj) {
    define_property_default()(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}
// EXTERNAL MODULE: ./src/components/vfa-picker/sass/styles.sass
var styles = __webpack_require__("be5b");

// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js?{"cacheDirectory":"node_modules/.cache/vue-loader","cacheIdentifier":"7fc3cbca-vue-loader-template"}!./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/vue-loader/lib??vue-loader-options!./src/components/vfa-picker/vfa-picker-component.vue?vue&type=template&id=34a597f6&scoped=true&
var render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{staticClass:"vfa"},[_c('transition',{attrs:{"name":"fade"}},[_c('div',{directives:[{name:"show",rawName:"v-show",value:(_vm.visible),expression:"visible"}],staticClass:"vfa-container",on:{"click":function($event){if($event.target !== $event.currentTarget){ return null; }_vm.closeOnContainerClick ? (_vm.visible = false) : undefined}}},[_c('div',{ref:"main",staticClass:"vfa-content",style:({ width: _vm.width, height: _vm.height })},[_c('div',{staticClass:"vfa-header"},[_c('div',{staticClass:"vfa-search"},[(_vm.searchable)?_c('input',{directives:[{name:"model",rawName:"v-model",value:(_vm.keyword),expression:"keyword"}],attrs:{"placeholder":"Search here...","type":"text"},domProps:{"value":(_vm.keyword)},on:{"input":function($event){if($event.target.composing){ return; }_vm.keyword=$event.target.value}}}):_vm._e()])]),_c('div',{staticClass:"vfa-icons-container"},[_c('div',{staticClass:"vfa-icons"},[_vm._l((_vm.currentIcons),function(icon){return [_c('div',{key:icon.class,class:['vfa-icon', _vm.selected(icon) ? 'selected' : undefined]},[_vm._t("icon",[_c('icon',{attrs:{"icon":icon},nativeOn:{"click":function($event){return _vm.picked(icon)}}})],{"icon":icon,"picked":_vm.picked})],2)]})],2)]),_c('div',{staticClass:"vfa-pagination"},[_c('h3',[_vm._v(_vm._s(_vm.icons.length)+" Icons")]),_vm._t("pagination",[_c('div',[_c('span',{staticClass:"vfa-pagination-item",on:{"click":_vm.previous}},[_vm._v("‹")]),_c('span',{staticClass:"vfa-pagination-item",on:{"click":_vm.next}},[_vm._v("›")])])],{"next":_vm.next,"previous":_vm.previous,"to":_vm.to})],2)])])]),_vm._t("activator",null,{"on":_vm.on})],2)}
var staticRenderFns = []


// CONCATENATED MODULE: ./src/components/vfa-picker/vfa-picker-component.vue?vue&type=template&id=34a597f6&scoped=true&

// EXTERNAL MODULE: ./node_modules/core-js/modules/es7.array.includes.js
var es7_array_includes = __webpack_require__("6762");

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.string.includes.js
var es6_string_includes = __webpack_require__("2fdb");

// EXTERNAL MODULE: ./node_modules/core-js/modules/es6.number.constructor.js
var es6_number_constructor = __webpack_require__("c5f6");

// EXTERNAL MODULE: ./src/components/vfa-picker/icons.json
var vfa_picker_icons = __webpack_require__("25c4");

// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js?{"cacheDirectory":"node_modules/.cache/vue-loader","cacheIdentifier":"7fc3cbca-vue-loader-template"}!./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/vue-loader/lib??vue-loader-options!./src/components/vfa-picker/icon.vue?vue&type=template&id=e092b224&
var iconvue_type_template_id_e092b224_render = function () {var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;return _c('div',{attrs:{"title":_vm.icon.label}},[_c('span',{class:[_vm.parent, ("fa-" + (_vm.icon.class)), 'vfa-icon-preview']}),_c('div',{staticClass:"vfa-icon-info"},[_c('span',{staticClass:"class"},[_vm._v(_vm._s(_vm.icon.class))])])])}
var iconvue_type_template_id_e092b224_staticRenderFns = []


// CONCATENATED MODULE: ./src/components/vfa-picker/icon.vue?vue&type=template&id=e092b224&

// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/vue-loader/lib??vue-loader-options!./src/components/vfa-picker/icon.vue?vue&type=script&lang=js&
//
//
//
//
//
//
//
//
//
/* harmony default export */ var iconvue_type_script_lang_js_ = ({
  name: "vfa-icon",
  props: {
    icon: {
      type: Object,
      required: true
    }
  },
  computed: {
    parent: function parent() {
      if (this.icon.styles.indexOf("regular") > -1) {
        return "fa";
      } else if (this.icon.styles.indexOf("solid") > -1) {
        return "fas";
      } else if (this.icon.styles.indexOf("brands") > -1) {
        return "fab";
      }

      return "";
    }
  }
});
// CONCATENATED MODULE: ./src/components/vfa-picker/icon.vue?vue&type=script&lang=js&
 /* harmony default export */ var vfa_picker_iconvue_type_script_lang_js_ = (iconvue_type_script_lang_js_); 
// CONCATENATED MODULE: ./node_modules/vue-loader/lib/runtime/componentNormalizer.js
/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file (except for modules).
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

function normalizeComponent (
  scriptExports,
  render,
  staticRenderFns,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier, /* server only */
  shadowMode /* vue-cli only */
) {
  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (render) {
    options.render = render
    options.staticRenderFns = staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = 'data-v-' + scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = shadowMode
      ? function () { injectStyles.call(this, this.$root.$options.shadowRoot) }
      : injectStyles
  }

  if (hook) {
    if (options.functional) {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      var originalRender = options.render
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return originalRender(h, context)
      }
    } else {
      // inject component registration as beforeCreate hook
      var existing = options.beforeCreate
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    }
  }

  return {
    exports: scriptExports,
    options: options
  }
}

// CONCATENATED MODULE: ./src/components/vfa-picker/icon.vue





/* normalize component */

var component = normalizeComponent(
  vfa_picker_iconvue_type_script_lang_js_,
  iconvue_type_template_id_e092b224_render,
  iconvue_type_template_id_e092b224_staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* harmony default export */ var icon = (component.exports);
// CONCATENATED MODULE: ./node_modules/cache-loader/dist/cjs.js??ref--12-0!./node_modules/thread-loader/dist/cjs.js!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--0-0!./node_modules/vue-loader/lib??vue-loader-options!./src/components/vfa-picker/vfa-picker-component.vue?vue&type=script&lang=js&



//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ var vfa_picker_componentvue_type_script_lang_js_ = ({
  name: "vfa-picker",
  props: {
    isUnicode: {
      type: [Boolean, String],
      required: false,
      default: false
    },
    isBoth: {
      type: [Boolean, String],
      required: false,
      default: false
    },
    itemsPerPage: {
      type: Number,
      required: false,
      default: 36
    },
    closeOnContainerClick: {
      type: Boolean,
      required: false,
      default: true
    },
    width: {
      type: String,
      default: "80%"
    },
    height: {
      type: String,
      default: "70%"
    },
    value: {
      type: String
    },
    only: {
      type: Array,
      default: function _default() {
        return ["solid", "regular", "brands"];
      }
    },
    searchable: {
      type: [Boolean, String],
      default: true
    }
  },
  components: {
    Icon: icon
  },
  data: function data() {
    return {
      visible: false,
      page: 1,
      keyword: undefined
    };
  },
  computed: {
    currentIcons: function currentIcons() {
      return this.icons.slice((this.page - 1) * this.itemsPerPage, this.page * this.itemsPerPage);
    },
    icons: function icons() {
      var _this = this;

      var icons = vfa_picker_icons.filter(function (icon) {
        return icon.styles.some(function (v) {
          return _this.only.indexOf(v) > -1;
        });
      });

      if (this.keyword) {
        icons = icons.filter(function (icon) {
          return _this.keyword ? icon.label.toLowerCase().includes(_this.keyword.toLowerCase()) : true;
        }); // eslint-disable-next-line

        this.page = 1;
      }

      return icons;
    },
    totalItems: function totalItems() {
      return this.icons.length;
    },
    totalPages: function totalPages() {
      return Math.ceil(this.icons.length / this.itemsPerPage);
    }
  },
  methods: {
    on: function on() {
      this.visible = true;
    },
    next: function next() {
      this.page + 1 < this.totalPages ? this.page++ : undefined;
    },
    previous: function previous() {
      this.page > 1 ? this.page-- : undefined;
    },
    to: function to(page) {
      this.page = page;
    },
    selected: function selected(icon) {
      return icon.class === this.value || icon.unicode === this.value;
    },
    picked: function picked(icon) {
      this.visible = false;
      if (this.isUnicode) return this.$emit("input", icon.unicode);

      if (this.isBoth) {
        this.$emit("update:class", icon.class);
        this.$emit("update:unicode", icon.unicode);
        this.$emit("input", {
          class: icon.class,
          unicode: icon.unicode
        });
        return;
      }

      return this.$emit("input", icon.class);
    }
  }
});
// CONCATENATED MODULE: ./src/components/vfa-picker/vfa-picker-component.vue?vue&type=script&lang=js&
 /* harmony default export */ var vfa_picker_vfa_picker_componentvue_type_script_lang_js_ = (vfa_picker_componentvue_type_script_lang_js_); 
// EXTERNAL MODULE: ./src/components/vfa-picker/vfa-picker-component.vue?vue&type=style&index=0&id=34a597f6&lang=sass&scoped=true&
var vfa_picker_componentvue_type_style_index_0_id_34a597f6_lang_sass_scoped_true_ = __webpack_require__("b01a");

// CONCATENATED MODULE: ./src/components/vfa-picker/vfa-picker-component.vue






/* normalize component */

var vfa_picker_component_component = normalizeComponent(
  vfa_picker_vfa_picker_componentvue_type_script_lang_js_,
  render,
  staticRenderFns,
  false,
  null,
  "34a597f6",
  null
  
)

/* harmony default export */ var vfa_picker_component = (vfa_picker_component_component.exports);
// CONCATENATED MODULE: ./src/components/vfa-picker/index.js









function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }




var vfa_picker_VueFontAwesomePicker = function VueFontAwesomePicker() {
  var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

  _classCallCheck(this, VueFontAwesomePicker);

  var defaults = {};
  this.options = _objectSpread({}, defaults, {}, options);
};

_defineProperty(vfa_picker_VueFontAwesomePicker, "install", function (Vue) {
  Vue.component("vfa-picker", vfa_picker_component);
});


// CONCATENATED MODULE: ./node_modules/@vue/cli-service/lib/commands/build/entry-lib.js


/* harmony default export */ var entry_lib = __webpack_exports__["default"] = (vfa_picker_VueFontAwesomePicker);



/***/ }),

/***/ "fdef":
/***/ (function(module, exports) {

module.exports = '\x09\x0A\x0B\x0C\x0D\x20\xA0\u1680\u180E\u2000\u2001\u2002\u2003' +
  '\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u3000\u2028\u2029\uFEFF';


/***/ })

/******/ });
//# sourceMappingURL=vfa-picker.common.js.map

/***/ })

}]);