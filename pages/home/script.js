import {
    ACESFilmicToneMapping,
    DirectionalLight,
    Group,
    MathUtils,
    Mesh,
    MeshStandardMaterial,
    PerspectiveCamera,
    PlaneGeometry,
    PMREMGenerator,
    PointLight,
    Raycaster,
    Scene,
    Vector2,
    Vector3,
    WebGLRenderer,
} from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { Sky } from 'three/addons/objects/Sky.js';
import { animate, frame } from 'motion';

import { updateAvatar } from '../../js/avatar.js';

const easeOutQuart = [0.25, 1, 0.5, 1];

const renderer = new WebGLRenderer({
    canvas: new OffscreenCanvas(1920, 1080),
    antialias: true,
    alpha: true,
});
renderer.shadowMap.enabled = true;
renderer.toneMapping = ACESFilmicToneMapping;
renderer.toneMappingExposure = Math.pow(2, -0.5);

const pmremGenerator = new PMREMGenerator(renderer);
pmremGenerator.compileEquirectangularShader();

document.addEventListener('DOMContentLoaded', async () => {
    const introductionScene = new IntroductionScene(
        renderer,
        document.querySelector('#introduction-canvas'),
    );

    await introductionScene.setup();

    frame.update(async ({ delta }) => {
        introductionScene.update(delta);
        await introductionScene.render();
    }, true);

    const avatars = document.querySelectorAll('.avatar');

    for (const avatar of avatars) {
        const firstName = avatar.dataset.firstName;
        const lastName = avatar.dataset.lastName;

        updateAvatar(avatar, firstName, lastName);
        avatar.classList.remove('animate-pulse');
    }
});

/** @param {string} text */
function animateHeaderText(text) {
    /** @type {HTMLSpanElement} */
    const target = document.querySelector('#header-product-text');

    target.innerHTML = '';

    for (let i = 0; i < text.length; ++i) {
        const letter = text[i];

        const container = document.createElement('span');
        container.style.position = 'relative';
        container.style.display = 'inline-block';
        container.style.paddingBottom = '15px';
        container.style.overflow = 'hidden';
        container.style.transformStyle = 'preserve-3d';
        container.style.perspective = '10000px';

        const back = document.createElement('span');
        back.style.position = 'absolute';
        back.style.display = 'inline-block';
        back.style.backfaceVisibility = 'hidden';
        back.style.transformOrigin = '50% 25%';
        back.textContent = letter == ' ' ? '\u00A0' : letter;
        container.append(back);

        animate(
            back,
            { y: 115 },
            { delay: i * 0.05, duration: 0.3, ease: [0.175, 0.885, 0.32, 1.1] },
        );

        const front = document.createElement('span');
        front.style.position = 'absolute';
        front.style.display = 'inline-block';
        front.style.backfaceVisibility = 'hidden';
        front.style.transformOrigin = '50% 100%';
        front.textContent = letter == ' ' ? '\u00A0' : letter;
        container.append(front);

        animate(
            front,
            { y: [-115, 0] },
            { delay: i * 0.05 + 0.05, duration: 0.3, ease: [0.175, 0.885, 0.32, 1.1] },
        );

        const invisible = document.createElement('span');
        invisible.style.visibility = 'hidden';
        invisible.textContent = letter == ' ' ? '\u00A0' : letter;
        container.append(invisible);

        target.append(container);
    }
}

const PlantNames = /** @type {const} */ ({
    FiddleLeafFig: 'Fiddle-Leaf Fig',
    PonytailPalm: 'Ponytail Palm',
    RhyzomePlant: 'Rhyzome Plant',
});

class IntroductionScene {
    /**
     * @param {WebGLRenderer} renderer
     * @param {HTMLCanvasElement} canvas
     */
    constructor(renderer, canvas) {
        this.renderer = renderer;
        this.canvas = canvas;

        /** @type {ImageBitmapRenderingContext} */
        this.context = canvas.getContext('bitmaprenderer');
    }

    async setup() {
        this.scene = new Scene();
        this.sceneEnv = new Scene();

        this.sky = new Sky();
        this.sky.scale.setScalar(10000);
        this.sceneEnv.add(this.sky);

        const phi = MathUtils.degToRad(90 - 4);
        const theta = MathUtils.degToRad(200);
        const sun = new Vector3();
        sun.setFromSphericalCoords(1, phi, theta);
        this.sky.material.uniforms['sunPosition'].value.copy(sun);
        this.sky.material.uniforms['turbidity'].value = 10;
        this.sky.material.uniforms['rayleigh'].value = 2;
        this.sky.material.uniforms['mieCoefficient'].value = 0.005;
        this.sky.material.uniforms['mieDirectionalG'].value = 0.8;

        const renderTarget = pmremGenerator.fromScene(this.sceneEnv);
        this.scene.add(this.sky);
        this.scene.environment = renderTarget.texture;

        this.camera = new PerspectiveCamera(75);
        this.camera.position.z = 5;
        this.scene.add(this.camera);

        this.controls = new OrbitControls(this.camera, this.canvas);

        this.directionalLight = new DirectionalLight(0xffffff, 10);
        this.directionalLight.castShadow = true;
        this.directionalLight.shadow.mapSize.set(2048, 2048);
        this.directionalLight.shadow.intensity = 0.5;
        this.directionalLight.position.set(-5, 1.5, -1);
        this.directionalLight.target.position.set(3, -2, 1);
        this.scene.add(this.directionalLight);
        this.scene.add(this.directionalLight.target);

        this.pointLight = new PointLight(0xffffff, 50);
        this.pointLight.shadow.mapSize.set(2048, 2048);
        this.pointLight.shadow.intensity = 0.5;
        this.pointLight.position.set(-3, 1, 1.5);
        this.scene.add(this.pointLight);

        this.ground = new Mesh(
            new PlaneGeometry(100, 5),
            new MeshStandardMaterial({
                color: 0x00ff00,
                transparent: true,
                alphaTest: 0.1,
                opacity: 0,
            }),
        );
        this.ground.castShadow = true;
        this.ground.receiveShadow = true;
        this.ground.position.set(0, -2.8, 0);
        this.ground.rotation.set(-1.6, 0, 0);
        this.scene.add(this.ground);

        animate(this.ground.material, { opacity: 0.8 }, { duration: 1, ease: 'linear' });

        this.shoppingCart = await loadModel('shopping-cart.glb');
        this.shoppingCart.position.set(-10, -2.75, 0);
        this.shoppingCart.rotation.set(0.0, 2.2, 0);
        this.shoppingCart.scale.setScalar(4);
        this.scene.add(this.shoppingCart);

        this.shoppingCart.traverse(node => {
            node.castShadow = true;
            node.receiveShadow = true;
        });

        this.shoppingCartAnimationCompleted = false;

        Promise.all([
            animate(
                this.shoppingCart.position,
                { x: -3.5 },
                { duration: 2, ease: easeOutQuart },
            ),
            animate(
                this.shoppingCart.rotation,
                { y: 1.6 },
                { duration: 2, ease: easeOutQuart },
            ),
        ]).then(() => {
            this.shoppingCartAnimationCompleted = true;
        });

        this.tableBox = new Group();
        this.tableBox.position.set(12, -2.8, 0);
        this.tableBox.rotation.set(-0.05, -0.3, 0);
        this.scene.add(this.tableBox);

        animate(this.tableBox.position, { x: 2.5 }, { duration: 2, ease: easeOutQuart });
        animate(this.tableBox.rotation, { y: -0.1 }, { duration: 2, ease: easeOutQuart });

        this.table = await loadModel('coffee-table.glb');
        this.table.castShadow = true;
        this.table.receiveShadow = true;
        this.table.scale.setScalar(3.5);
        this.tableBox.add(this.table);

        const plants = await loadModel('plants.glb');

        this.fiddleLeafFig = plants.getObjectByName('SnakePlant_02').clone();
        this.fiddleLeafFig.castShadow = true;
        this.fiddleLeafFig.receiveShadow = true;
        this.fiddleLeafFig.name = PlantNames['FiddleLeafFig'];
        this.fiddleLeafFig.position.set(-1.2, 1.44, -0.2);
        this.fiddleLeafFig.scale.setScalar(3.5);
        this.tableBox.add(this.fiddleLeafFig);

        this.ponytailPalm = plants.getObjectByName('Epipremium001').clone();
        this.ponytailPalm.castShadow = true;
        this.ponytailPalm.receiveShadow = true;
        this.ponytailPalm.name = PlantNames['PonytailPalm'];
        this.ponytailPalm.position.set(0, 1.45, 0.1);
        this.ponytailPalm.rotation.set(0, 0.8, 0);
        this.ponytailPalm.scale.setScalar(3.5);
        this.tableBox.add(this.ponytailPalm);

        this.rhyzomePlant = plants.getObjectByName('Palm_03').clone();
        this.rhyzomePlant.castShadow = true;
        this.rhyzomePlant.receiveShadow = true;
        this.rhyzomePlant.name = PlantNames['RhyzomePlant'];
        this.rhyzomePlant.position.set(1.3, 1.45, 0.2);
        this.rhyzomePlant.scale.setScalar(4);
        this.tableBox.add(this.rhyzomePlant);

        this.tableBox.traverse(node => {
            node.castShadow = true;
            node.receiveShadow = true;
        });

        this.raycaster = new Raycaster();

        this.pointerMoved = false;
        this.pointer = new Vector2();

        document.addEventListener('pointermove', event => {
            this.pointerMoved = true;
            this.pointer.x = (event.clientX / this.canvas.clientWidth) * 2 - 1;
            this.pointer.y = -((event.clientY / this.canvas.clientHeight) * 2 - 1);
        });

        this.plantHover = null;
        this.plantClicked = false;

        document.addEventListener('pointerdown', () => {
            this.plantClicked = true;
        });

        this.activePushAnimations = 0;
    }

    /** @param {(typeof PlantNames)[keyof typeof PlantNames]} name */
    #pushPlantToCart(name) {
        let plant;

        if (name == PlantNames.FiddleLeafFig) {
            plant = this.fiddleLeafFig.clone();
            plant.position.set(
                MathUtils.randFloat(-0.08, 0.04),
                0.95,
                MathUtils.randFloat(-0.15, 0.2),
            );
            plant.scale.setScalar(0.6);

            animate(plant.position, { y: 0.38 }, { duration: 0.5, ease: easeOutQuart });
        }

        if (name == PlantNames.PonytailPalm) {
            plant = this.ponytailPalm.clone();
            plant.position.set(
                MathUtils.randFloat(-0.05, 0.05),
                1.1,
                MathUtils.randFloat(-0.15, 0.25),
            );
            plant.scale.setScalar(0.6);

            animate(plant.position, { y: 0.37 }, { duration: 0.5, ease: easeOutQuart });
        }

        if (name == PlantNames.RhyzomePlant) {
            plant = this.rhyzomePlant.clone();
            plant.position.set(
                MathUtils.randFloat(-0.1, 0.1),
                0.9,
                MathUtils.randFloat(-0.15, 0.2),
            );
            plant.scale.setScalar(0.6);

            animate(plant.position, { y: 0.37 }, { duration: 0.5, ease: easeOutQuart });
        }

        plant.castShadow = false;
        plant.receiveShadow = false;
        this.shoppingCart.add(plant);
    }

    resize() {
        const width = this.canvas.clientWidth;
        const height = this.canvas.clientHeight;

        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.setSize(width, height, false);

        this.canvas.width = width;
        this.canvas.height = height;

        this.camera.aspect = width / height;
        this.camera.updateProjectionMatrix();
    }

    /** @param {number} delta */
    update(delta) {
        if (this.shoppingCartAnimationCompleted) {
            this.shoppingCart.rotation.x = this.pointer.y * 0.1 + 0.0;
            this.shoppingCart.rotation.y = this.pointer.x * 0.2 + 1.6;
        }

        if (this.pointerMoved) {
            this.raycaster.setFromCamera(this.pointer, this.camera);

            const intersects = this.raycaster.intersectObjects([
                this.ponytailPalm,
                this.fiddleLeafFig,
                this.rhyzomePlant,
            ]);

            for (const intersection of intersects) {
                if (this.fiddleLeafFig.getObjectById(intersection.object.id)) {
                    if (this.plantHover != PlantNames.FiddleLeafFig) {
                        animateHeaderText(PlantNames.FiddleLeafFig);
                    }

                    this.plantHover = PlantNames.FiddleLeafFig;

                    if (this.plantClicked) {
                        this.#pushPlantToCart(PlantNames.FiddleLeafFig);
                        this.plantClicked = false;
                    }
                }

                if (this.ponytailPalm.getObjectById(intersection.object.id)) {
                    if (this.plantHover != PlantNames.PonytailPalm) {
                        animateHeaderText(PlantNames.PonytailPalm);
                    }

                    this.plantHover = PlantNames.PonytailPalm;

                    if (this.plantClicked) {
                        this.#pushPlantToCart(PlantNames.PonytailPalm);
                        this.plantClicked = false;
                    }
                }

                if (this.rhyzomePlant.getObjectById(intersection.object.id)) {
                    if (this.plantHover != PlantNames.RhyzomePlant) {
                        animateHeaderText(PlantNames.RhyzomePlant);
                    }

                    this.plantHover = PlantNames.RhyzomePlant;

                    if (this.plantClicked) {
                        this.#pushPlantToCart(PlantNames.RhyzomePlant);
                        this.plantClicked = false;
                    }
                }
            }

            this.plantClicked = false;
            document.body.style.cursor = intersects.length ? 'pointer' : 'auto';
        }
    }

    async render() {
        this.resize();

        this.renderer.render(this.scene, this.camera);

        const bitmapImage = await window.createImageBitmap(this.renderer.domElement);
        this.context.transferFromImageBitmap(bitmapImage);
    }
}

const gltfLoader = new GLTFLoader();

/**
 * @param {string} name
 * @returns {Promise<Group>}
 */
async function loadModel(name) {
    const path = `../../public/models/${name}`;
    const model = await gltfLoader.loadAsync(path);

    return model.scene;
}
