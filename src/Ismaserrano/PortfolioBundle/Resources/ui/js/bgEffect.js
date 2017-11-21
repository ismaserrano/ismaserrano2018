/**
 * Created by ismaelserrano on 16/11/17.
 */
var IsmaserranoPortfolioBundle = IsmaserranoPortfolioBundle || {};

IsmaserranoPortfolioBundle.bgEffect = (function($, window, undefined) {

    var init;
    var self = this;
    var bgFile = '';
    var animating = true;

    var camera, scene, renderer,
        geometry, material, mesh,
        animationId, light, smokeTexture;

    var analyser, sound;
    var freq = 1000;
    var buffer;
    var url = 'frontend/music/stranger.mp3';

    var frequencyData;
    var projectBgPlane = null;
    var sceneParticles;

    var mouseX = 0, mouseY = 0, mouseActivated = false;

    var windowHalfX = window.innerWidth / 2;
    var windowHalfY = window.innerHeight / 2;

    init = function(callback) {

        clock = new THREE.Clock();

        renderer = new THREE.WebGLRenderer();
        renderer.setSize( window.innerWidth, window.innerHeight );

        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 10000 );
        camera.position.z = 1000;
        scene.add( camera );

        geometry = new THREE.CubeGeometry( 200, 200, 200 );
        material = new THREE.MeshLambertMaterial( { color: 0xaa6666, wireframe: false } );
        mesh = new THREE.Mesh( geometry, material );
        //scene.add( mesh );
        cubeSineDriver = 0;

        light = new THREE.DirectionalLight(0xffffff,0.9);
        light.position.set(-1,0,1);
        scene.add(light);

        smokeTexture = new THREE.TextureLoader().load(bgFile);
        smokeMaterial = new THREE.MeshLambertMaterial({color: 0x00dddd, map: smokeTexture, transparent: true});
        smokeGeo = new THREE.PlaneGeometry(500,500);
        smokeParticles = [];

        for (p = 0; p < 20; p++) {
            var particle = new THREE.Mesh(smokeGeo, smokeMaterial);
            particle.position.set(Math.random()*500-250, Math.random()*500-250, Math.random()*1000-100);
            particle.rotation.z = Math.random() * 360;
            scene.add(particle);
            smokeParticles.push(particle);
        }

        // document.body.appendChild( renderer.domElement );
        $('#image-bg').html(renderer.domElement);

        window.addEventListener( 'resize', onWindowResize, false );

        callback();
    };

    updateTexture = function() {
        scene.remove(projectBgPlane);
        projectBgPlane = null;
        $.each(smokeParticles, function(index, el){
            scene.remove(el);
        });
        document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
        mouseActivated = false;

        smokeTexture = new THREE.TextureLoader().load(bgFile, function(texture){
            smokeMaterial = new THREE.MeshLambertMaterial({color: 0x00dddd, map: smokeTexture, transparent: true});
            smokeGeo = new THREE.PlaneGeometry(500,500);
            smokeParticles = [];

            for (p = 0; p < 20; p++) {
                var particle = new THREE.Mesh(smokeGeo, smokeMaterial);
                particle.position.set(Math.random()*500-250, Math.random()*500-250, Math.random()*1000-100);
                particle.rotation.z = Math.random() * 360;
                scene.add(particle);
                smokeParticles.push(particle);
            }
        });
    };

    projectTexture = function() {
        var self = this;

        $.each(smokeParticles, function(index, el){
            scene.remove(el);
        });

        var smokeTexture = new THREE.TextureLoader().load(bgFile, function(texture){
            imagePlane = new THREE.Mesh(
                new THREE.PlaneGeometry(texture.image.width, texture.image.height),
                new THREE.MeshLambertMaterial({
                    map: smokeTexture,
                    color: 0x00dddd,
                    opacity: 0.3
                })
            );
            imagePlane.position.set(0, 0, (window.innerWidth / window.innerHeight) * 100 );
            scene.add(imagePlane);

            projectBgPlane = imagePlane;

            document.addEventListener( 'mousemove', onDocumentMouseMove, false );
            mouseActivated = true;

        });

        render();

        // var targets = [
        //     {
        //         type: ParticleSaga.ImageTarget,
        //         url: bgFile,
        //         options: {
        //             respondsToMouse: false,
        //             size: 6
        //         }
        //     }
        // ];
        // // The scene's context element
        // var saga = document.getElementById('image-bgTemp');
        //
        // sceneParticles = new IsmaserranoPortfolioBundle.particleSaga.ParticleSaga.Scene(saga, targets, {
        //     numParticles: 40000
        // });
        // sceneParticles.load(function() {
        //     sceneParticles.setTarget(0);
        //     // IsmaserranoPortfolioBundle.particleSaga.ParticleSaga.animate();
        // });

        // callback();

    };

    loadMusic = function() {
        var listener = new THREE.AudioListener();
        camera.add( listener );

        // create an Audio source
        sound = new THREE.Audio( listener );
        var audioLoader = new THREE.AudioLoader();

        //Load a sound and set it as the Audio object's buffer
        audioLoader.load( url, function( buffer ) {
            sound.setBuffer( buffer );
            sound.setLoop(true);
            sound.setVolume(1);
            sound.play();
        });

        //Create an AudioAnalyser, passing in the sound and desired fftSize
        analyser = new THREE.AudioAnalyser( sound, 32 );
    };

    setMusicVolume = function(volume) {
        sound.setVolume(volume);
    };

    setBgFile = function(file, callback) {
        bgFile = file;
        callback();
    };

    animate = function() {
        // note: three.js includes requestAnimationFrame shim
        delta = clock.getDelta();
        if (typeof analyser !== 'undefined') {
            frequencyData = analyser.getAverageFrequency();
            // sceneParticles.setFrequencyData(frequencyData);
            freq = (analyser.getAverageFrequency() / 1200) * (1250 - 850) + 850;
            camera.position.z = freq;
            // var randomIndex = Math.random() * (scene.children.length - 0) + 0;
            // if (typeof scene.children[randomIndex]!=='undefined' && scene.children[randomIndex].type == 'Mesh') {
            //     scene.children[randomIndex].position.z = freq * 1000 - 100;
            // }

        }
        animationId = requestAnimationFrame( animate );
        evolveSmoke();
        render();
        animating = true;
    };

    stopAnimate = function() {
        cancelAnimationFrame( animationId );
        light.intensity = 1;
        render();
        animating = false;
    };

    evolveSmoke = function() {
        var sp = smokeParticles.length;
        while(sp--) {
            smokeParticles[sp].rotation.z += (delta * 0.2);
        }
        if (projectBgPlane === null) {
            light.intensity = Math.random() * (1 - 0.3) + 0.3;
        } else {
            light.intensity = 1;
        }
    };

    render = function() {

        if (mouseActivated) {
            camera.position.x += ( mouseX - camera.position.x ) * .05;
            camera.position.y += ( -mouseY - camera.position.y ) * .05;
        } else {
            camera.position.x = 0;
            camera.position.y = 0;
        }
        camera.lookAt(scene.position);

        mesh.rotation.x += 0.005;
        mesh.rotation.y += 0.01;
        cubeSineDriver += .01;
        mesh.position.z = 100 + (Math.sin(cubeSineDriver) * 500);
        renderer.render( scene, camera );

    };

    onWindowResize = function(){

        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();

        renderer.setSize( window.innerWidth, window.innerHeight );

    };

    onDocumentMouseMove = function( event ) {
        mouseX = ( event.clientX - windowHalfX ) / 2;
        mouseY = ( event.clientY - windowHalfY ) / 2;
    };

    return {
        init: init,
        animate: animate,
        setBgFile: setBgFile,
        stopAnimate: stopAnimate,
        loadMusic: loadMusic,
        setMusicVolume: setMusicVolume,
        updateTexture: updateTexture,
        projectTexture: projectTexture,
        animating: animating,
        frequencyData: frequencyData
    };

}(jQuery, window));