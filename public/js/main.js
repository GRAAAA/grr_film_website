//Import the THREE.js library
import * as THREE from "https://cdn.skypack.dev/three@0.129.0/build/three.module.js";
import { OrbitControls } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js";

//Create a Three.JS Scene
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

let object;
let controls;

//Set which object to render
let objToRender = "film_roll";

//Instantiate a loader for the .gltf file
const loader = new GLTFLoader();

//Load the file
loader.load(
  `./models/${objToRender}/scene.gltf`,
  function (gltf) {
    object = gltf.scene;
    object.scale.set(100, 100, 100);

    // Look straight from the top
    object.rotation.x = -Math.PI / -2; // 90 degrees in radians
    object.position.y = 0; // optional, adjust if needed

    scene.add(object);
  },
  function (xhr) {
    console.log((xhr.loaded / xhr.total * 100) + "% loaded");
  },
  function (error) {
    console.error("An error occurred while loading the model:", error);
  }
);

//Instantiate a new renderer and set its size
const renderer = new THREE.WebGLRenderer({ alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);

// ✅ Fix container ID mismatch
document.getElementById("container3D").appendChild(renderer.domElement);

//Set how far the camera will be from the 3D model
camera.position.z = 500;

// Base soft ambient lights
scene.add(new THREE.AmbientLight(0x222222, 3.5));
scene.add(new THREE.AmbientLight(0xED775A, 1.0));
scene.add(new THREE.HemisphereLight(0xED775A, 0xaaaaaa, 0.5));

// Gentle highlights from the side
const softHighlight = new THREE.DirectionalLight(0xffffff, 0.2);
softHighlight.position.set(100, 200, 100);
scene.add(softHighlight);

// Light in front of the object, pointing at its center
const frontLight = new THREE.DirectionalLight(0xffffff, 0.3); // adjust intensity
frontLight.position.set(0, 0, 300);  // in front along Z-axis
frontLight.target.position.set(0, 0, 0); // aim at object center
scene.add(frontLight);
scene.add(frontLight.target);

//OrbitControls
controls = new OrbitControls(camera, renderer.domElement);
controls.enableZoom = false;
controls.enablePan = false;
// Animate/render loop
function animate() {
  requestAnimationFrame(animate);

  // Rotate slowly around Y-axis (center)
  if (object) {
    object.rotation.y += 0.002; // adjust speed (radians/frame)
  }

  renderer.render(scene, camera);
}

window.addEventListener("resize", function () {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
});

animate();
