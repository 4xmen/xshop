import { BufferAttribute, Clock, Color, PerspectiveCamera, PlaneGeometry, Points, Scene, ShaderMaterial, WebGLRenderer } from 'three';

window.addEventListener('load',function () {

    if (document.querySelector('canvas#webgl') == null){
        return ;
    }
    /**
     |--------------------------------------------------
     | Constants
     |--------------------------------------------------
     */
    const sizes = {
        width: window.innerWidth,
        height: window.innerHeight
    }
    const canvas = document.querySelector('canvas#webgl');
    const scene = new Scene()
    /**
     |--------------------------------------------------
     | Camera
     |--------------------------------------------------
     */
    const camera = new PerspectiveCamera(75, sizes.width / sizes.height, 0.1, 100)
    camera.position.z = 10
    camera.position.y = 1.1
    camera.position.x = 0
    scene.add(camera)





// const color = 0xFFFFFF;
// const intensity = 3;
// const light = new THREE.DirectionalLight( color, intensity );
// light.position.set( - 1, 2, 4 );
// scene.add( light );


    /**
     |--------------------------------------------------
     | Plane
     |--------------------------------------------------
     */
    const planeGeometry = new PlaneGeometry(20, 20, 250, 250)
    const planeMaterial = new ShaderMaterial({
        uniforms: {
            uTime: { value: 0 },
            uElevation: { value: 0.482 }
        },
        vertexShader: `
        uniform float uTime;
        uniform float uElevation;

        attribute float aSize;

        varying float vPositionY;
        varying float vPositionZ;

        void main() {
            vec4 modelPosition = modelMatrix * vec4(position, 1.0);
            modelPosition.y = sin(modelPosition.x - uTime) * sin(modelPosition.z * 0.6 + uTime) * uElevation;

            vec4 viewPosition = viewMatrix * modelPosition;
            gl_Position = projectionMatrix * viewPosition;

            gl_PointSize = 2.0 * aSize;
            gl_PointSize *= ( 1.0 / - viewPosition.z );

            vPositionY = modelPosition.y;
            vPositionZ = modelPosition.z;
        }
    `,
        fragmentShader: `
        varying float vPositionY;
        varying float vPositionZ;

        void main() {
            float strength = (vPositionY + 0.25) * 0.3;
            gl_FragColor = vec4(3.0, 0.0, 0.0, strength);
        }
    `,
        transparent: true,
    })
    const planeSizesArray = new Float32Array(planeGeometry.attributes.position.count)
    for (let i = 0; i < planeSizesArray.length; i++) {
        planeSizesArray[i] = Math.random() * 4.0
    }
    planeGeometry.setAttribute('aSize', new BufferAttribute(planeSizesArray, 1))

    const plane = new Points(planeGeometry, planeMaterial)
    plane.rotation.x = - Math.PI * 0.4
    scene.add(plane)

    /**
     |--------------------------------------------------
     | Resize
     |--------------------------------------------------
     */
    window.addEventListener('resize', () => {
        // Update sizes
        sizes.width = window.innerWidth
        sizes.height = window.innerHeight

        // Update camera
        camera.aspect = sizes.width / sizes.height
        camera.updateProjectionMatrix()

        // Update renderer
        renderer.setSize(sizes.width, sizes.height)
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2))
    })

    /**
     |--------------------------------------------------
     | Renderer
     |--------------------------------------------------
     */
    const renderer = new WebGLRenderer({
        canvas: canvas,
        alpha: true,
        antialias: true
    })
    renderer.setSize(sizes.width, sizes.height)
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2))

    /**
     |--------------------------------------------------
     | Animate Function
     |--------------------------------------------------
     */
    const clock = new Clock()

    const animate = () => {
        const elapsedTime = clock.getElapsedTime()

        planeMaterial.uniforms.uTime.value = elapsedTime

        renderer.render(scene, camera)

        // Call animate again on the next frame
        window.requestAnimationFrame(animate)
    }

    animate();
});
