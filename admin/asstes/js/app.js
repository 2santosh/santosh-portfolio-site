import ready, { HTML } from "Utils";

ready(() => {
  HTML.classList.add("is-loaded");
});

// jQuery document ready
// jQuery(function() {
//   // init functions
// });

// vanilla document ready
// document.addEventListener('DOMContentLoaded', function () {
//   // do something here ...
// }, false);

chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
  if (message.action === "fetchData") {
    fetchData()
      .then((data) => {
        sendResponse({ data: data });
      })
      .catch((error) => {
        sendResponse({ error: error.message });
      });
    return true; // Keeps the message channel open for the asynchronous response
  }
});
