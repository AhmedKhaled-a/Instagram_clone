const images = document.querySelectorAll('#carousel img');
// const pagintation = document.querySelector('#pagintation');


function createPaginationMarkers() {
  images.forEach((img) => {
    const imgViewName = `--${img.id}`;
    img.style.viewTimelineName = imgViewName;
    const marker = document.createElement('button');
    marker.type = 'button';
    marker.role = 'tab';
    marker.style.animationTimeline = imgViewName;
  });

  document.body.style.timelineScope = `${Array.from(images).map(
    (image) => image.style.viewTimelineName
  )}`;
}

// Check browser support for Scroll-driven Animations
// if (CSS.supports('view-timeline-axis', 'inline')) {
//   createPaginationMarkers();
// }
