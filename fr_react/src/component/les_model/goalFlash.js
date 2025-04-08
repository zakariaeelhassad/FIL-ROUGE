// component/animations/GoalFlash.js
import React from 'react';
import { motion, AnimatePresence } from 'framer-motion';

const GoalFlash = ({ show }) => {
  return (
    <AnimatePresence>
      {show && (
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          exit={{ opacity: 0 }}
          style={{
            position: 'fixed',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            backgroundColor: 'rgba(255, 255, 255, 0.8)',
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center',
            zIndex: 100
          }}
        >
          <motion.div
            initial={{ scale: 0 }}
            animate={{ scale: 1 }}
            transition={{ duration: 0.5 }}
            style={{
              fontSize: '5rem',
              fontWeight: 'bold',
              color: '#3910b4',
              textShadow: '2px 2px 4px rgba(0, 0, 0, 0.5)'
            }}
          >
            BUUUUT !!!
          </motion.div>
        </motion.div>
      )}
    </AnimatePresence>
  );
};

export default GoalFlash;
