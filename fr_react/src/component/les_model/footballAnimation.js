// component/animations/FootballAnimation.js
import React, { useState, useEffect, useRef } from 'react';
import { motion } from 'framer-motion';

const FootballAnimation = () => {
  const [footballs, setFootballs] = useState([]);
  const containerRef = useRef(null);

  const createFootball = () => {
    const newFootball = {
      id: Date.now(),
      x: Math.random() * window.innerWidth,
      y: -50,
      rotation: Math.random() * 360
    };
    setFootballs(prev => [...prev, newFootball]);
  };

  useEffect(() => {
    const footballInterval = setInterval(createFootball, 500);
    const burstInterval = setInterval(() => {
      for (let i = 0; i < 5; i++) {
        createFootball();
      }
    }, 3000);

    for (let i = 0; i < 10; i++) {
      setTimeout(createFootball, i * 200);
    }

    return () => {
      clearInterval(footballInterval);
      clearInterval(burstInterval);
    };
  }, []);

  return (
    <div
      ref={containerRef}
      style={{
        position: 'fixed',
        top: 0,
        left: 0,
        width: '100%',
        height: '100%',
        zIndex: 0,
        pointerEvents: 'none',
        overflow: 'hidden'
      }}
    >
      {footballs.map((ball) => (
        <motion.div
          key={ball.id}
          initial={{ y: ball.y, x: ball.x, rotate: ball.rotation }}
          animate={{ y: window.innerHeight, rotate: ball.rotation + 360 }}
          transition={{ duration: 5, ease: "easeInOut" }}
          style={{
            position: 'absolute',
            width: '80px',
            height: '80px',
            backgroundImage: 'url(/path/to/football-image.png)',
            backgroundSize: 'contain',
            backgroundRepeat: 'no-repeat'
          }}
          onAnimationComplete={() => {
            setFootballs(prev => prev.filter(f => f.id !== ball.id));
          }}
        />
      ))}
    </div>
  );
};

export default FootballAnimation;
