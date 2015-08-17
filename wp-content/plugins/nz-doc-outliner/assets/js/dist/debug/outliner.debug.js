/**
 * This code contains an implementation of HTML5 outlining algorithm, as described by WHATWG at [1]
 *
 * The copyright notice at [2] says:
 *		(c) Copyright 2004-2009 Apple Computer, Inc., Mozilla Foundation, and Opera Software ASA.
 *		You are granted a license to use, reproduce and create derivative works of this document.
 *
 * [1] http://www.whatwg.org/specs/web-apps/current-work/multipage/sections.html#outlines
 * [2] http://www.whatwg.org/specs/web-apps/current-work/multipage/index.html
 */

(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.HTML5Outline = f()}})(function(){var define,module,exports;return (function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
module.exports = require("./src/createOutline");

},{"./src/createOutline":6}],2:[function(require,module,exports){
var asHTML = require("./asHTML");

function Outline(outlineTarget, onlySection) {
	this.startingNode = outlineTarget.node;
	this.sections = [onlySection];
}

Outline.prototype.getLastSection = function () {
	return this.sections[this.sections.length - 1];
};

Outline.prototype.asHTML = function (options) {
	return asHTML(this.sections, options);
};

module.exports = Outline;

},{"./asHTML":5}],3:[function(require,module,exports){
/**
 * Internal data structure to avoid adding properties onto native objects
 *
 * @param {Element} node
 * @constructor
 */
function OutlineTarget(node)
{
	this.node = node;
}

module.exports = OutlineTarget;

},{}],4:[function(require,module,exports){
function Section(startingNode) {
	this.sections = [];
	this.startingNode = startingNode;
}

Section.prototype.append = function (what) {
	what.container = this;
	this.sections.push(what);
};

module.exports = Section;

},{}],5:[function(require,module,exports){
var utils = require("./utils");

function sectionHeadingText(section) {

	if (section.heading.implied) {
		return "<i>Untitled " + utils.getTagName(section.startingNode) + "</i>";
	}

	var elHeading = utils.getRankingHeadingElement(section.heading);
	if (!elHeading) {
		return "<i>Error: no H1-H6 inside HGROUP</i>";
	}

	var textContent = elHeading.textContent;
	if (!textContent) {
		return "<i>No text content inside " + utils.getTagName(elHeading) + "</i>";
	}

	return utils.escapeHtml(textContent);
}

function getId(section, options) {
	var sectionId = section.startingNode.getAttribute('id');
	if (sectionId) {
		return sectionId;
	}

	if (!section.heading.implied) {
		var headingId = section.heading.getAttribute('id');
		if (headingId) {
			return headingId;
		}
	}

	var node = section.startingNode;
	do {
		var id = 'h5o-' + (++options.linkCounter);
	} while (node.ownerDocument.getElementById(id));

	node.setAttribute('id', id);
	return id;
}

function asHTML(sections, options) {

	if (typeof(options) !== "object") {
		// if second argument is not an object - it must be the boolean for `createLinks` (backwards compat)
		options = {
			createLinks: !!options
		}
	}

	if (!sections.length) {
		return '';
	}

	if (options.skipTopHeader) {
		return asHTML(sections[0].sections, {
			skipToHeader: false,
			createLinks: options.createLinks
		})
	}

	if (typeof(options.linkCounter) === "undefined") {
		options.linkCounter = 0;
	}

	var createLinks = !!options.createLinks;
	var result = [];

	result.push("<ol>");

	for (var i = 0; i < sections.length; i++) {
		var section = sections[i];
		result.push("<li>");

		if (createLinks) {
			result.push('<a href="#' + getId(section, options) + '">');
		}

		result.push(sectionHeadingText(section));

		if (createLinks) {
			result.push("</a>");
		}

		result.push(asHTML(section.sections, options));
		result.push("</li>");
	}

	result.push("</ol>");

	return result.join("");
}

module.exports = asHTML;

},{"./utils":7}],6:[function(require,module,exports){
var Section = require("./Section"),
	Outline = require("./Outline"),
	OutlineTarget = require("./OutlineTarget"),
	walk = require("./walk"),
	utils = require("./utils");

var currentOutlineTarget, currentSection, stack;

function stackTopNode() {
	if (!stack.length) return;
	return stack[stack.length - 1].node;
}

function getRank(heading) {
	var rankingElement = utils.getRankingHeadingElement(heading);
	if (!rankingElement) {
		// The rank of an hgroup element is the rank of the highest-ranked h1–h6 element descendant of the hgroup
		// element, if there are any such elements, or otherwise the same as for an h1 element (the highest rank).
		// ref: https://html.spec.whatwg.org/#the-hgroup-element
		return -1; // rank of H1
	}
	return -parseInt(utils.getTagName(rankingElement).substr(1));
}

function onEnterNode(node) {

	// If the top of the stack is a heading content element or an element with a hidden attribute
	// Do nothing.
	var stackTop = stackTopNode();
	if (utils.isHeading(stackTop) || utils.hasHiddenAttribute(stackTop)) {
		return;
	}

	// When entering an element with a hidden attribute
	// Push the element being entered onto the stack. (This causes the algorithm to skip that element and any
	// descendants of the element.)
	if (utils.hasHiddenAttribute(node)) {
		stack.push({node: node});
		return;
	}

	// When entering a sectioning content element
	if (utils.isSecContent(node)) {

		// If current outline target is not null, run these substeps:
		if (currentOutlineTarget != null) {
			// If the current section has no heading, create an implied heading and let that be the heading for the
			// current section.
			if (!currentSection.heading) {
				currentSection.heading = {implied: true};
			}

			// Push current outline target onto the stack.
			stack.push(currentOutlineTarget);
		}

		// Let current outline target be the element that is being entered.
		currentOutlineTarget = new OutlineTarget(node);

		// Let current section be a newly created section for the current outline target element.
		// @todo: Associate current outline target with current section.
		currentSection = new Section(node);

		// Let there be a new outline for the new current outline target, initialised with just the new current section
		// as the only section in the outline.
		currentOutlineTarget.outline = new Outline(currentOutlineTarget.node, currentSection);
		return;
	}

	// When entering a sectioning root element
	if (utils.isSecRoot(node)) {

		// If current outline target is not null, push current outline target onto the stack.
		if (currentOutlineTarget != null) {
			stack.push(currentOutlineTarget);
		}

		// Let current outline target be the element that is being entered.
		currentOutlineTarget = new OutlineTarget(node);

		// Let current outline target's parent section be current section.
		currentOutlineTarget.parentSection = currentSection;

		// Let current section be a newly created section for the current outline target element.
		currentSection = new Section(node);

		// Let there be a new outline for the new current outline target, initialised with just the new current section
		// as the only section in the outline.
		currentOutlineTarget.outline = new Outline(currentOutlineTarget.node, currentSection);
		return;
	}

	// When entering a heading content element
	if (utils.isHeading(node)) {

		// If the current section has no heading, let the element being entered be the heading for the current section.
		if (!currentSection.heading) {
			currentSection.heading = node;

			// Otherwise, if the element being entered has a rank equal to or higher than the heading of the last section of
			// the outline of the current outline target, or if the heading of the last section of the outline of the current
			// outline target is an implied heading, then
		} else if (currentOutlineTarget.outline.getLastSection().heading.implied || getRank(node) >= getRank(currentOutlineTarget.outline.getLastSection().heading)) {

			// create a new section and
			var newSection = new Section(node);

			// append it to the outline of the current outline target element, so that this new section is the new last
			// section of that outline.
			currentOutlineTarget.outline.sections.push(newSection);

			// Let current section be that new section.
			currentSection = newSection;

			// Let the element being entered be the new heading for the current section.
			currentSection.heading = node;

			// Otherwise, run these substeps:
		} else {

			var abortSubsteps = false;

			// Let candidate section be current section.
			var candidateSection = currentSection;

			// Heading loop:
			do {
				// note:
				// if candidateSection is still currentSection - it definitely has a heading, because otherwise
				// `node`, which is a heading, would be a heading for that section

				// if the heading for currentSection is higher (or same), e.g. `node` is H2 and currentSection.heading is H1
				// then our `node` creates a subsection and we don't need to care about anything else

				// if our `node` is actually higher, e.g. `node` is H3, and currentSection.heading is H4
				// H4 is not the last child of the outline target [and therefore not the only child]
				// therefore there must exist an element of at least H3 or higher rank
				// that is the outline parent of the H4 and that element of H3 or higher
				// would then be hit by going upwards
				// therefore getSectionHeadingRank is sure that candidateSection.heading is not implied

				// If the element being entered has a rank lower than the rank of the heading of the candidate section, then
				if (getRank(node) < getRank(candidateSection.heading)) {

					// create a new section,
					var newSection = new Section(node);

					// and append it to candidate section. (This does not change which section is the last section in the outline.)
					candidateSection.append(newSection);

					// Let current section be this new section.
					currentSection = newSection;

					// Let the element being entered be the new heading for the current section.
					currentSection.heading = node;

					// Abort these substeps.
					abortSubsteps = true;
				}

				// Let new candidate section be the section that contains candidate section in the outline of current outline target.
				var newCandidateSection = candidateSection.container;

				// Let candidate section be new candidate section.
				candidateSection = newCandidateSection;

				// Return to the step labeled heading loop.
			} while (!abortSubsteps);
		}

		// Push the element being entered onto the stack. (This causes the algorithm to skip any descendants of the element.)
		stack.push({node: node});
		return;
	}

	// Otherwise
	// Do nothing.
}

function onExitNode(node) {


	// When exiting an element, if that element is the element at the top of the stack
	// Note: The element being exited is a heading content element or an element with a hidden attribute.
	// Pop that element from the stack.
	var stackTop = stackTopNode();
	if (stackTop === node) {
		stack.pop();
	}

	// If the top of the stack is a heading content element or an element with a hidden attribute
	// Do nothing.
	if (utils.isHeading(stackTop) || utils.hasHiddenAttribute(stackTop)) {
		return;
	}

	// When exiting a sectioning content element, if the stack is not empty
	if (utils.isSecContent(node) && stack.length > 0) {

		// If the current section has no heading, create an implied heading and let that be the heading for the current section.
		if (!currentSection.heading) {
			currentSection.heading = {implied: true};
		}

		var targetBeingExited = currentOutlineTarget; // note: `targetBeingExited.node` is `node`

		// Pop the top element from the stack, and let the current outline target be that element.
		currentOutlineTarget = stack.pop();

		// Let current section be the last section in the outline of the current outline target element.
		currentSection = currentOutlineTarget.outline.getLastSection();

		// Append the outline of the sectioning content element being exited to the current section.
		// (This does not change which section is the last section in the outline.)
		for (var i = 0; i < targetBeingExited.outline.sections.length; i++) {
			currentSection.append(targetBeingExited.outline.sections[i]);
		}
		return;
	}

	// When exiting a sectioning root element, if the stack is not empty
	if (utils.isSecRoot(node) && stack.length > 0) {

		// If the current section has no heading, create an implied heading and let that be the heading for the current section.
		if (!currentSection.heading) {
			currentSection.heading = {implied: true};
		}

		// Let current section be current outline target's parent section.
		currentSection = currentOutlineTarget.parentSection;

		// Pop the top element from the stack, and let the current outline target be that element.
		currentOutlineTarget = stack.pop();
		return;
	}

	// The current outline target is the element being exited, and it is the sectioning content element or a sectioning
	// root element at the root of the subtree for which an outline is being generated.
	// Note: The current outline target is the element being exited, and it is the sectioning content element or
	// a sectioning root element at the root of the subtree for which an outline is being generated.
	if (utils.isSecContent(node) || utils.isSecRoot(node)) {

		// If the current section has no heading, create an implied heading and let that be the heading for the current section.
		if (!currentSection.heading) {
			currentSection.heading = {implied: true};
		}

		// Skip to the next step in the overall set of steps. (The walk is over.)
		return;
	}

	// Otherwise
	// Do nothing.
}

function createOutline(start) {

	if (!utils.isSecContent(start) && !utils.isSecRoot(start)) {
		throw new TypeError("Invalid argument: start element must either be sectioning root or sectioning content.");
	}

	// Let current outline target be null.
	// (It holds the element whose outline is being created.)
	currentOutlineTarget = null;

	// Let current section be null.
	// (It holds a pointer to a section, so that elements in the DOM can all be associated with a section.)
	currentSection = null;

	// Create a stack to hold elements, which is used to handle nesting. Initialise this stack to empty.
	stack = [];

	// Walk over the DOM in tree order, starting with the sectioning content element or sectioning root element at the
	// root of the subtree for which an outline is to be created, and trigger the first relevant step below for each
	// element as the walk enters and exits it.
	walk(start, onEnterNode, onExitNode);

	// @todo: In addition, whenever the walk exits a node, after doing the steps above, if the node is not associated with a section yet, associate the node with the section current section.
	// @todo: Associate all non-element nodes that are in the subtree for which an outline is being created with the section with which their parent element is associated.
	// @todo: Associate all nodes in the subtree with the heading of the section with which they are associated, if any.

	// `currentOutlineTarget` cannot be null, since we can only `start` at sectioning root/content
	// and entering sectioning root/content always sets a `currentOutlineTarget`
	return currentOutlineTarget.outline;

}

module.exports = createOutline;

},{"./Outline":2,"./OutlineTarget":3,"./Section":4,"./utils":7,"./walk":8}],7:[function(require,module,exports){
function getTagName(el) {
	return el.tagName.toUpperCase(); // upper casing due to http://ejohn.org/blog/nodename-case-sensitivity/
}

function tagChecker(regexString) {
	return function (el) {
		return isElement(el) && (new RegExp(regexString, "i")).test(getTagName(el));
	}
}

function isElement(obj) {
	return obj && obj.tagName;
}

var isHeading = tagChecker('^H[1-6]|HGROUP$');

function getRankingHeadingElement(heading) {
	if (!isHeading(heading)) {
		throw new Error("Not a heading element");
	}

	var elTagName = getTagName(heading);
	if (elTagName !== "HGROUP") {
		return heading;
	}

	// find highest ranking heading inside HGROUP
	for (var i = 1; i <= 6; i++) {
		var headings = heading.getElementsByTagName("H" + i);
		if (headings.length) {
			return headings[0];
		}
	}

	// HGROUP has no headings...
	return null;
}

function escapeHtml(str) {
	return (""+str).replace(/&/g, "&amp;").replace(/</g, "&lt;");
}

function hasHiddenAttribute(el) {
	return isElement(el) && el.hasAttribute("hidden");
}

exports.getTagName = getTagName;

exports.hasHiddenAttribute = hasHiddenAttribute;
exports.isSecRoot = tagChecker('^(BLOCKQUOTE|BODY|DETAILS|FIELDSET|FIGURE|TD)$');
exports.isSecContent = tagChecker('^(ARTICLE|ASIDE|NAV|SECTION)$');
exports.isHeading = isHeading;
exports.getRankingHeadingElement = getRankingHeadingElement;

exports.escapeHtml = escapeHtml;

},{}],8:[function(require,module,exports){
module.exports = function (root, enter, exit) {
	var node = root;
	start: while (node) {
		enter(node);
		if (node.firstChild) {
			node = node.firstChild;
			continue start;
		}
		while (node) {
			exit(node);
			if (node.nextSibling) {
				node = node.nextSibling;
				continue start;
			}
			if (node == root)
				node = null;
			else
				node = node.parentNode;
		}
	}
};

},{}]},{},[1])(1)
});