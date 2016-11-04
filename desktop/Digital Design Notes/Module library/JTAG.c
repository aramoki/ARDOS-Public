// JTAG parallel cable demo code
// (c) fpga4fun.com KNJN LLC 2006

// This code assumes that you have a JTAG parallel cable connected to your PC
// Works with Xilinx parallel III or Altera ByteBlasterMV/II

// Linux port by Brent A. Thorne (mrThorne@hotmail.com) 
// June 4, 2006
// to compile type: "gcc -DLINUX -O JTAG.c -o jtag" 
// run as root or set uid: "chmod +s jtag"^M

///////////////////////////////////////////////////////////
// Make sure you define one of these (XILINX or ALTERA)
#define XILINX
//#define ALTERA

// Make sure you define one of these (WINDOWS or LINUX)
#define WINDOWS
//#define LINUX

#define lpt_addr 0x378		// change this if your printer port is at a different address
#define MaxIR_ChainLength 1000

///////////////////////////////////////////////////////////
#include <stdio.h>
#include <assert.h>

#ifdef WINDOWS
#include <windows.h>
#include <conio.h>
#endif

#ifdef LINUX
#include <stdlib.h>
#include <unistd.h>
 // #include <asm/io.h> <asm/io.h> is deprecated, use <sys/io.h> instead
#include <sys/io.h>
#include <string.h>
#define WORD unsigned short
#define BYTE unsigned char
#define DWORD unsigned int 
#endif

///////////////////////////////////////////////////////////
#ifdef ALTERA	// Altera ByteBlasterMV/II
#define TDOMASK 0x80
#define TDOHIGH 0x00
#define TDI 0x40
#define TMS 0x02
#define TCK 0x01
#define JTAG_ENABLE 0x00
// Cyclone: IR length = 10
#define IR_SAMPLE_PRELOAD 0x005
#define IR_IDCODE 0x006
#define IR_READ_USERCODE 0x007
#define IR_HIGHZ 0x00B
#define IR_BYPASS 0x3FF
#endif

#ifdef XILINX	// PARALLEL III cable
#define TDOMASK 0x10
#define TDOHIGH 0x10
#define TDI 0x01
#define TMS 0x04
#define TCK 0x02
#define JTAG_ENABLE 0x10
// Spartan-3: IR length = 6
#define IR_SAMPLE_PRELOAD 0x01
#define IR_READ_USERCODE 0x08
#define IR_IDCODE 0x09
#define IR_HIGHZ 0x0A
#define IR_BYPASS 0x3F
#endif

#define IDCODE_MANUF_XILINX 0x49
#define IDCODE_MANUF_XILINX_FAMILY_SPARTAN3 0x0A

#define IDCODE_MANUF_ALTERA 0x6E
#define IDCODE_MANUF_ALTERA_FAMILY_CYCLONE 0x10

///////////////////////////////////////////////////////////
// this function opens a driver that allows IO space accesses
// this is required on Windows 2000 and XP
// make sure you installed GiveIo or UserPort on your machine before running this
void EnablePrinterPort()
{
#ifdef WINDOWS
	// use either GiveIO or UserPort
//	HANDLE h = CreateFile ("\\\\.\\GiveIO", GENERIC_READ, 0, NULL, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);
	HANDLE h = CreateFile ("\\\\.\\UserPort", GENERIC_READ, 0, NULL, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);
	if(h == INVALID_HANDLE_VALUE)
	{
		printf ("error: could not get port access.\n");
		exit(-1);
	}
	CloseHandle(h);	// close the device now (simply opening it once is enough to enable the port accesses)
#endif
#ifdef LINUX
	if (ioperm(lpt_addr,1,1) || ioperm(lpt_addr+1,1,1))
    		fprintf(stderr, "Couldn't get the port at %x\n", lpt_addr), exit(1);
#endif
}

void outport(WORD addr, BYTE data)
{
#ifdef WINDOWS
	__asm
	{
		mov dx, addr
		mov al, data
		out dx, al
	}
#endif
#ifdef LINUX
	outb(data, addr);
#endif
}

BYTE inport(WORD addr)
{
#ifdef WINDOWS
	__asm
	{
		mov dx, addr
		in al, dx
	}
#endif
#ifdef LINUX
	return inb(addr);
#endif
}

void JTAG_EnableParallelCable()
{
#ifdef ALTERA
	outport(lpt_addr, 0x10);
	if(inport(lpt_addr+1) & 0x40)
	{
		printf("ALTERA ByteBlaster-II detected\n");
		outport(lpt_addr+2, 0);	// Auto Linefeed (enables Altera's ByteBlaster-II cable)
	}
	else
	{
		printf("ALTERA ByteBlasterMV detected\n");
		outport(lpt_addr+2, 2);	// Auto Linefeed (enables Altera's ByteBlasterMV cable)
	}
#endif
}

///////////////////////////////////////////////////////////
BYTE JTAG_clock(BYTE port_data)
{
	BYTE result;

	port_data |= JTAG_ENABLE;
	outport(lpt_addr, port_data);
	result = inport(lpt_addr+1);
	outport(lpt_addr, (BYTE)(port_data | TCK));
	outport(lpt_addr, port_data);

	return (result & TDOMASK)==TDOHIGH;
}

void JTAG_EnterShiftIR()
{
	JTAG_clock(TMS);
	JTAG_clock(0);
	JTAG_clock(0);
}

void JTAG_EnterShiftDR()
{
	JTAG_clock(0);
	JTAG_clock(0);
}

void JTAG_ExitShift()
{
	JTAG_clock(TMS);
	JTAG_clock(TMS);
	JTAG_clock(TMS);
}

int JTAG_DetermineChainLength(char* s)
{
	int i;

	// empty the chain (fill it with 0's)
	for(i=0; i<MaxIR_ChainLength; i++) JTAG_clock(0);

	// feed the chain with 1's
	for(i=0; i<MaxIR_ChainLength; i++) if(JTAG_clock(TDI)) break;

	printf("%s = %d\n", s, i);
	JTAG_ExitShift();
	return i;
}

void JTAG_SendData(char* p, int bitlength)
// note: call this function only when in shift-IR or shift-DR state
{
	int bitofs = 0;

	assert(bitlength);  // make sure there is at least one bit to send (we can't send zero if we're already there)
	bitlength--;
	while(bitlength--)
	{
		JTAG_clock((BYTE)((p[bitofs/8] >> (bitofs & 7) & 1) ? TDI : 0));  // send all bits but the last one
		bitofs++;
	}
	JTAG_clock((BYTE)((p[bitofs/8] >> (bitofs & 7) & 1) ? TDI | TMS : TMS));  // send last bit, with TMS asserted
	JTAG_clock(TMS);
	JTAG_clock(TMS);  // go back to select-DR
}

void JTAG_ReadData(char* p, int bitlength)
// note: call this function only when in shift-IR or shift-DR state
{
	int bitofs = 0;
	memset(p, 0, (bitlength+7)/8);

	assert(bitlength);  // make sure there is at least one bit to read (we can't send zero if we're already there)
	bitlength--;
	while(bitlength--)
	{
		p[bitofs/8] |= (JTAG_clock(0) << (bitofs & 7));	// read all bits but the last one
		bitofs++;
	}
	p[bitofs/8] |= (JTAG_clock(TMS) << (bitofs & 7));  // read the last bit, with TMS asserted
	JTAG_clock(TMS);
	JTAG_clock(TMS);  // go back to select-DR
}

///////////////////////////////////////////////////////////
int IRlen, nDevices;

void JTAG_SetIR(DWORD IR)
{
	JTAG_EnterShiftIR();
	JTAG_SendData((char*) &IR, IRlen);
}

void JTAG_SendDR(char* p, int bitlength)
{
	JTAG_EnterShiftDR();
	JTAG_SendData(p, bitlength);
}

void JTAG_ReadDR(char* p, int bitlength)
{
	JTAG_EnterShiftDR();
	JTAG_ReadData(p, bitlength);
}

void JTAG_reset()
{
	int i;

	// go to reset state
	for(i=0; i<5; i++) JTAG_clock(TMS);

	// go to select DR
	JTAG_clock(0);
	JTAG_clock(TMS);
}

///////////////////////////////////////////////////////////
struct 
{
	int onebit:1;
	int manuf:11;
	int size:9;
	int family:7;
	int rev:4;
} idcode[20];	// max 20 devices

void JTAG_Scan()
{
	int i;

	JTAG_reset();
	JTAG_EnterShiftIR();
	IRlen = JTAG_DetermineChainLength("IR chain length");

	// we are in BYPASS mode since JTAG_DetermineChainLength filled the IR chain full of 1's
	// now we can easily determine the number of devices (= DR chain length when all the devices are in BYPASS mode)
	JTAG_EnterShiftDR();
	nDevices = JTAG_DetermineChainLength("Number of device(s)");

	// read the IDCODEs (assume all devices support IDCODE, so read 32 bits per device)
	JTAG_reset();
	JTAG_ReadDR((char*)idcode, 32*nDevices);
	for(i=0; i<nDevices; i++)
	{
		assert(idcode[i].onebit);  // if the bit is zero, that means IDCODE is not supported for this device
		printf("Device %d IDCODE: %08X (Manuf %03X, Part size %03X, Family code %02X, Rev %X)\n", i+1, idcode[i], idcode[i].manuf, idcode[i].size, idcode[i].family, idcode[i].rev);
	}
}

///////////////////////////////////////////////////////////
int main()
{
	EnablePrinterPort();
	JTAG_EnableParallelCable();

	JTAG_Scan();
	printf("done - press a key to exit");	
#ifdef WINDOWS
	getch();
#endif
#ifdef LINUX
	getchar();
#endif
	return 0;
}
