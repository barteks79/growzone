import {
    ACESFilmicToneMapping,
    Group,
    PerspectiveCamera,
    PMREMGenerator,
    Raycaster,
    Scene,
    Vector2,
    WebGLRenderer,
} from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';
import { animate, frame } from 'motion';

const easeOutQuart = [0.25, 1, 0.5, 1];

const renderer = new WebGLRenderer({
    canvas: new OffscreenCanvas(100, 100),
    antialias: true,
    alpha: true,
});
renderer.toneMapping = ACESFilmicToneMapping;
renderer.toneMappingExposure = Math.pow(2, 0);

const pmremGenerator = new PMREMGenerator(renderer);
pmremGenerator.compileEquirectangularShader();

const neutralEnvironment = pmremGenerator.fromScene(new RoomEnvironment()).texture;

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
});

const PlantNames = /** @type {const} */ ({
    PonytailPalm: 'Ponytail Palm',
    FiddleLeafFig: 'Fiddle-Leaf Fig',
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
        this.scene.environment = neutralEnvironment;

        this.camera = new PerspectiveCamera(75);
        this.camera.position.z = 5;
        this.scene.add(this.camera);

        this.shoppingCart = await loadGLTFModel('shopping-cart.glb');
        this.shoppingCart.position.set(-10, -2.6, 0);
        this.shoppingCart.rotation.set(0.0, 2.2, 0);
        this.shoppingCart.scale.setScalar(4);
        this.scene.add(this.shoppingCart);

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

        this.table = await loadGLTFModel('coffee-table.glb');
        this.table.scale.setScalar(3.5);
        this.tableBox.add(this.table);

        this.ponytailPalm = await loadGLTFModel('ponytail-palm.glb');
        this.ponytailPalm.name = PlantNames['PonytailPalm'];
        this.ponytailPalm.position.set(-1, 2.4, -0.2);
        this.ponytailPalm.scale.setScalar(0.1);
        this.tableBox.add(this.ponytailPalm);

        this.fiddleLeafFig = await loadGLTFModel('fiddle-leaf-fig.glb');
        this.fiddleLeafFig.name = PlantNames['FiddleLeafFig'];
        this.fiddleLeafFig.position.set(-0.08, 1.45, 0.1);
        this.fiddleLeafFig.rotation.set(0, 0.8, 0);
        this.fiddleLeafFig.scale.setScalar(1.5);
        this.tableBox.add(this.fiddleLeafFig);

        this.rhyzomePlant = await loadGLTFModel('rhyzome-plant.glb');
        this.rhyzomePlant.name = PlantNames['RhyzomePlant'];
        this.rhyzomePlant.position.set(1.3, 1.45, 0.2);
        this.rhyzomePlant.scale.setScalar(1.5);
        this.tableBox.add(this.rhyzomePlant);

        this.raycaster = new Raycaster();

        this.pointerMoved = false;
        this.pointer = new Vector2();

        document.addEventListener('pointermove', event => {
            this.pointerMoved = true;
            this.pointer.x = (event.clientX / this.canvas.clientWidth) * 2 - 1;
            this.pointer.y = -((event.clientY / this.canvas.clientHeight) * 2 - 1);
        });

        /** @type {HTMLSpanElement} */
        this.headerProductText = document.querySelector('#header-product-text');
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
                if (this.ponytailPalm.getObjectById(intersection.object.id)) {
                    this.headerProductText.textContent = this.ponytailPalm.name;
                }

                if (this.fiddleLeafFig.getObjectById(intersection.object.id)) {
                    this.headerProductText.textContent = this.fiddleLeafFig.name;
                }

                if (this.rhyzomePlant.getObjectById(intersection.object.id)) {
                    this.headerProductText.textContent = this.rhyzomePlant.name;
                }
            }
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
async function loadGLTFModel(name) {
    const path = `../../public/models/${name}`;
    const model = await gltfLoader.loadAsync(path);

    return model.scene;
}
